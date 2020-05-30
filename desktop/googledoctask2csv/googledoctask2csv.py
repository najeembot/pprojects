#!/usr/bin/env python3
from doc2task import Doc2Tasks
import csv
import re
import argparse
from __future__ import print_function
import pickle
import os.path
from googleapiclient.discovery import build
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
import json


def build_command_arguments():
    """Build the command line argument parser."""
    parser = argparse.ArgumentParser(
        description="Convert a Google Description of Work document into a Task list CSV. H2 -> Section. H3->Tasks. The name of the document will become the filename."
    )
    parser.add_argument(
        'Auth_token',
        help='Your auth token file such as token.pickle'
    )
    parser.add_argument(
        'Credentials_file',
        help='Your credentials file such as credentials.json'
    )
    parser.add_argument(
        'Document_id',
        help='Your document id'
    )
    parser.add_argument(
        'Scopes',
        help='Your document scopes url'
    )
    parser.add_argument(
        '--v', '--verbose',
        help='Ouput debugging messages',
        action='store_true'
    )
    args = parser.parse_args()
    return args

def to_filename(s):
    """Escape a string to be filename-safe."""
    s = str(s).strip().replace(' ', '_')
    return re.sub(r'(?u)[^-\w.]', '', s)

def write_to_csv(csv_headers, csv_data, csv_output_file):
    # opening the csv file and writing each task into it after the csv headers
    with open(csv_output_file, 'w', newline='') as csvfile:
        writer = csv.DictWriter(csvfile, fieldnames=csv_headers)
        writer.writeheader()
        for task in csv_data:
            writer.writerow(task)

def main():
    """Main function."""
    args = build_command_arguments()
    creds = None
    SCOPES = args.Scopes
    DOCUMENT_ID = args.Document_id
    CREDENTIALS_FILE = args.Credentials_file
    AUTH_TOKEN = args.Auth_token
    """ The file token.pickle stores the user's access and refresh tokens, and is
     created automatically when the authorization flow completes for the first
    time"""
    if os.path.exists(AUTH_TOKEN):
        with open(AUTH_TOKEN, 'rb') as token:
            creds = pickle.load(token)
    # If there are no (valid) credentials available, let the user log in.
    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(
                CREDENTIALS_FILE, SCOPES)
            creds = flow.run_local_server(port=0)
        # Save the credentials for the next run
        with open(AUTH_TOKEN, 'wb') as token:
            pickle.dump(creds, token)

    service = build('docs', 'v1', credentials=creds)
    # Retrieve the documents contents from the Docs service.
    # and writing each task in csv file
    document = service.documents().get(documentId=DOCUMENT_ID).execute()
    doc_to_tasks = Doc2Tasks(document, verbose=True)
    doc_to_tasks.run()
    output_file = "{}.csv".format(to_filename(doc_to_tasks.project_name))
    tasks = doc_to_tasks.tasks
    if len(tasks) > 0:
        if args.v:
            print("{} tasks found. Saving document as {}".format(len(tasks), output_file))
        headers = list(tasks[0].keys())
        print(json.dumps(doc_to_tasks.tasks, indent=4))
        write_to_csv(headers, doc_to_tasks.tasks, output_file)    
    else:
        if args.v:
            print("No tasks found. Didn't save a document")


if __name__ == "__main__":
    main()


"""
Usage:
$ ./googledoctask2csv.py "credentials/credentials.json" "credentials/token.pickle" "https://docs.google.com/document/d/169jYCTKSE4hcliGtU1pE2H45t2EPwoIhyGfVG4APWy0/edit#" "169jYCTKSE4hcliGtU1pE2H45t2EPwoIhyGfVG4APWy0"

For Help:
$ ./googledoctask2csv.py -h

"""
# program main screen with command arguments
