#!/bin/bash

changedFiles=$(git diff --name-status HEAD^ HEAD)
echo "$changedFiles"

if echo "$changedFiles" | grep -q "wp-content/themes/RSNE"; then
    echo "##vso[task.setvariable variable=runNodeTask]true"
    echo "##vso[task.setvariable variable=themeDirectory]wp-content/themes/RSNE"                
    echo "Files in wp-content/themes/sample have been changed."
elif echo "$changedFiles" | grep -q "wp-content/themes/avkare"; then
    echo "##vso[task.setvariable variable=runNodeTask]true"
    echo "##vso[task.setvariable variable=themeDirectory]wp-content/themes/avkare"
    echo "Files in wp-content/themes/example have been changed."
else
    echo "##vso[task.setvariable variable=runNodeTask;isOutput=true]false"
    echo "No changes in wp-content/."
fi
