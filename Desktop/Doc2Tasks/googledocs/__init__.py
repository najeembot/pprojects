import pickle
import os.path
from googleapiclient.discovery import build
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
import re


class GoogleDoc:
    """GoogleDoc API Client.

    This object creates a Python interface to the Google Docs API
    It requires:
    - A credentials JSON file (obtained when you create a new API client in console.google.com)
    - An OAuth Token file location to save stored credentials

    It returns to the user:
    - A reference to a GoogleDoc with the googleapiclient API interface
    """

    in_verbose_mode = False
    credentials = None
    oauth_token_file = None
    scopes = ['https://www.googleapis.com/auth/documents.readonly']

    def __init__(self, oauth_token_file, credentials_json_file, verbose=False):
        """Initialize Class."""
        self.in_verbose_mode = verbose
        self.say("In verbose mode")
        self.say("setting oauth token file to '{}'".format(oauth_token_file))
        self.set_oauth_token_file(oauth_token_file)
        self.set_credentials_json_file(credentials_json_file)

    def set_oauth_token_file(self, oauth_token_file):
        """Set the oauth token file to store Google login."""
        self.say("setting oauth token file to: {}".format(oauth_token_file))
        self.oauth_token_file = oauth_token_file

    def set_credentials_json_file(self, credentials_json_file):
        """Set the oauth token file to store Google login."""
        self.say("setting credentials_json_file to: {}".format(credentials_json_file))
        self.credentials_json_file = credentials_json_file

    def get_document_id_from_url(self, url):
        """Get a document id from a url."""
        matches = re.findall(r'\/document\/d\/([^\/]*)', url)
        if len(matches) > 0:
            return matches[0]
        else:
            return url

    def get_document(self, document_id_or_url):
        """Authorize access to document."""
        self.say("authorizing document")
        document_id = document_id_or_url
        if document_id_or_url.startswith('http'):
            document_id = self.get_document_id_from_url(document_id_or_url)
        if os.path.exists(self.oauth_token_file):
            with open(self.oauth_token_file, 'rb') as token:
                self.credentials = pickle.load(token)
        if not self.credentials or not self.credentials.valid:
            if self.credentials and self.credentials.expired and self.credentials.refresh_token:
                self.credentials.refresh(Request())
            else:
                flow = InstalledAppFlow.from_client_secrets_file(
                    self.credentials_json_file, self.scopes
                )
                self.credentials = flow.run_local_server(port=0)
            # Save credentials for the next run
            with open(self.oauth_token_file, 'wb') as token:
                pickle.dump(self.credentials, token)
        self.service = build('docs', 'v1', credentials=self.credentials)
        self.say("returning document")
        document = self.service.documents().get(documentId=document_id).execute()
        return document

    def say(self, message):
        """Print debugging messages."""
        if self.in_verbose_mode is True:
            print("[{}]: {}".format(self.__class__.__name__, message))


"""
# Use:
oauth_token_file = 'credentials/oauth_token.pkl'
credentials_json_file = 'credentials/credentials.json'
document_id = '169jYCTKSE4hcliGtU1pE2H45t2EPwoIhyGfVG4APWy0'
google_doc = GoogleDoc(oauth_token_file, credentials_json_file)
document = google_doc.get_document(document_id)
"""
