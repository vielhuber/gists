- Feature will *only* be enabled, when you manually create a `acf-json` folder in your themes folder
- Then there are stored JSON files everytime you make a change in the backend under fields (in `group_*.json`-files)
- JSON files always have priority in the frontend
- In the backend you see an image of the database (not the json)
- **Sync available** is displayed if the json is more recent than the database
- When syncing, no files are changed and the database will be updated with the changes from the json files
- If you want to ditch the json files, make sure to sync the database from the json files(!); Then you can delete the `acf-json`-folder

tl;dr
- Only use the feature if necessary
- Never exclude the acf-json folder (it must be inside git)
- Before editing fields in the backend:
  - Always check if git is up to date and all updates on acf json files are applied
  - Always click on **Sync** (otherwise, you will overwrite old data with new data!)
