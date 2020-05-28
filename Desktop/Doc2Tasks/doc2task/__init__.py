from __future__ import print_function
import math

class Doc2Tasks:
    """Doc2Tasks Convert a GoogleDoc into a specially formatted task list.
    This requires a specially-formatted Google Doc, where
    - H1 is the Section name
    - H2 is the Milestone task name
    - H3 are regular task names
    - All other text are descriptions of the task
    It operates using a state machine.
    It walks through each paragraph of the Google doc and looks at the
    format of the paragraph.
    - If the paragraph is regular text,
      it appends the text to a "current_task_descriptions" list
    - If the paragraph is a bullet, the same thing is done except that
      it looks at the indentation level so it can preserve the list format in the CSV
    - If the paragraph is a header, it looks at the header type to determine
      if the header represents a task name, a milestone, or a section
    - If it is a task, milestone, or section, it SAVES THE TASK STATE and CLEARS THE STATE
      and inputs the new information or so it can continue with the next task
    The output of this class is a dict that's specially formatted to be
    ready for export to CSV, based on the Asana CSV Importer guidelines:
    - https://asana.com/guide/help/api/csv-importer
    """

    document = None
    in_verbose_mode = False
    data = {}
    SECTION_STYLE_NAME = 'HEADING_2'
    MILESTONE_STYLE_NAME = 'HEADING_3'
    TASK_STYLE_NAME = 'HEADING_4'
    TASK_TYPE_MILESTONE = 'Milestone'

    # State
    current_section = None
    current_task_title = None
    current_task_descriptions = []

    project_name = None
    is_milestone = False
    tasks = []
    base_indent_magnitude = None
    def __init__(self, google_doc, verbose=False):
        """Initialize class."""
        self.in_verbose_mode = verbose
        self.say("In verbose mode")
        self.load_google_doc(google_doc)

    def load_google_doc(self, google_doc):
        """Load google doc."""
        self.document = google_doc

    def get_project_name(self):
        """Get the projcet name from the Google doc."""
        return self.document.get('title')

    def run(self):
        """Convert Google doc Scope of Work to CSV."""
        self.project_name = self.get_project_name()
        content_rows = self.document.get('body').get('content')
        self.say("found {} paragraphs".format(str(len(content_rows))))
        for content_row in content_rows:
            paragraph = content_row.get('paragraph')
            if paragraph is not None:
                style = paragraph.get('paragraphStyle').get('namedStyleType')
                if style == self.SECTION_STYLE_NAME:
                    if self.current_task_title is not None:
                        self.add_task()
                    self.current_task_title = None
                    self.current_task_descriptions = []
                    self.current_section = paragraph.get('elements')[0].get('textRun').get('content').strip()
                    self.say("found section: {}".format(self.current_section))
                elif style == self.MILESTONE_STYLE_NAME:
                    if self.current_section is not None:
                        if self.current_task_title is not None:
                            self.add_task()
                        self.is_milestone = True
                        self.current_task_title = paragraph.get('elements')[0].get('textRun').get('content').strip()
                        self.current_task_descriptions = []
                        self.say("  found milestone: {}".format(self.current_task_title))
                elif style == self.TASK_STYLE_NAME:
                    if self.current_section is not None:
                        self.current_task_title = paragraph.get('elements')[0].get('textRun').get('content').strip()
                        self.current_task_descriptions = []
                        self.say("  found milestone: {}".format(self.current_task_title))
                else:
                    bullet_info = paragraph.get('bullet')
                    if bullet_info is None:
                        self.list_depth_stack = []
                        self.current_task_descriptions += ['\n'] + [p.get('textRun').get('content').strip() for p in paragraph.get('elements')]
                    else:
                        # create a nested list
                        indent_magnitude = paragraph.get('paragraphStyle').get('indentStart').get('magnitude')
                        if self.base_indent_magnitude is None:
                            self.base_indent_magnitude = indent_magnitude
                        list_depth = math.ceil(indent_magnitude / self.base_indent_magnitude) - 1
                        self.current_task_descriptions += ['\n{}-'.format(list_depth * '    ')] + [p.get('textRun').get('content').strip() for p in paragraph.get('elements')]
        # there should be a task that was never added
        if self.current_task_title:
            self.add_task()


    def add_task(self, is_milestone=False):
        """Add a task to the stack."""
        task_type = None
        if is_milestone is True:
            task_type = self.TASK_TYPE_MILESTONE
        task = {
            'Task': self.current_task_title.replace("_", " ").replace('”', '"').replace('“', '"').replace("’", "'").replace('→', '->'),
            'Task Description': " ".join(self.current_task_descriptions).replace("_", " ").replace('”', '"').replace('“', '"').replace("’", "'").replace('→', '->'),
            'Assignee': None,
            'Follower': None,
            'Due Date': None,
            'Start Date': None,
            'Type': task_type,
            'Section/Column': self.current_section.replace("_", " ").replace('”', '"').replace('“', '"').replace("’", "'").replace('→', '->'),
        }
        self.is_milestone = False
        self.list_depth_stack = []
        self.tasks.append(task)
        return task

    def say(self, message):
        """Print debugging messages."""
        if self.in_verbose_mode is True:
            print("[{}]: {}".format(self.__class__.__name__, message))


# adding tasks to for ouput csv file
