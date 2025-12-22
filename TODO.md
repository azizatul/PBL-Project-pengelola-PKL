# Fix TranskipNilaiController.php Errors

## Issues Identified:
1. Duplicate and unreachable code in index() method
2. Inconsistent file storage paths across methods
3. Incorrect Auth guard usage in update() method
4. File path inconsistencies in destroy(), download(), and viewPdf() methods

## Plan:
- [x] Remove duplicate code in index() method
- [x] Standardize file storage to 'public/transkrips' with file_path = 'transkrips/filename'
- [x] Fix authentication in update() method to use Auth::user() and find mahasiswa
- [x] Update file path references in destroy(), download(), and viewPdf() methods
- [x] Ensure consistent validation and error handling
