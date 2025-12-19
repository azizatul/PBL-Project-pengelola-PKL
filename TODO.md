# TODO: Enable Mahasiswa to Upload Transkip Nilai

## Problem Analysis
- Mahasiswa cannot upload transkip nilai files
- Root cause: Controller uses Auth::user() (web guard) but mahasiswa authenticate with 'mahasiswa' guard
- Auth::user() returns null for mahasiswa, causing access denial

## Plan
1. Update TranskipNilaiController to check mahasiswa authentication using Auth::guard('mahasiswa')->user()
2. Ensure proper user verification in store, edit, update, and destroy methods
3. Test the upload functionality

## Files to Edit
- app/Http/Controllers/TranskipNilaiController.php

## Changes Made
- [x] Updated store() method to use Auth::guard('mahasiswa')->user()
- [x] Updated edit() method to use Auth::guard('mahasiswa')->user()
- [x] Updated update() method to use Auth::guard('mahasiswa')->user()
- [x] Updated destroy() method to use Auth::guard('mahasiswa')->user()

## Followup Steps
- [ ] Test upload functionality as mahasiswa
- [ ] Verify file storage and database records
