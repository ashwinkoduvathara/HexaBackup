#!/bin/bash

# Directory to back up (pass this as an argument)
USER_DIR=$1

# Backup destination (user's home directory)
BACKUP_DIR="$USER_DIR/backup"

# Create the backup directory if it doesn't exist
mkdir -p "$BACKUP_DIR"

# Create the backup with a timestamp
TIMESTAMP=$(date +"%Y%m%d%H%M%S")
BACKUP_FILE="$BACKUP_DIR/backup-$TIMESTAMP.tar.gz"

# Check if user directory exists
if [ -d "$USER_DIR" ]; then
    # Create a compressed archive of the user directory
    tar -czvf "$BACKUP_FILE" "$USER_DIR"
    echo "Backup created at: $BACKUP_FILE"
else
    echo "Directory $USER_DIR does not exist!"
    exit 1
fi
