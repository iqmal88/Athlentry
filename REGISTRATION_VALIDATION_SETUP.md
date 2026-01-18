# Student Registration Validation Implementation

## Overview
The student registration system now validates that students register with the **correct name and matric ID combination** from the official student registry.

## What Changed

### 1. New Database Table: `student_registry`
- **File**: `database/migrations/2026_01_19_000000_create_student_registry_table.php`
- **Purpose**: Stores the official list of students with their matric numbers and names
- **Columns**:
  - `MatricNo` (unique) - Student's matric ID
  - `Name` - Student's full name
  - `Email` - Optional email
  - `Department` - Optional department

### 2. New Model: `StudentRegistry`
- **File**: `app/Models/StudentRegistry.php`
- **Methods**:
  - `findByMatricAndName($matricNo, $name)` - Validates the name + matric combination
  - `isValidMatric($matricNo)` - Checks if matric exists in registry

### 3. Updated Registration Controller
- **File**: `app/Http/Controllers/AuthController.php`
- **Change**: Added validation check in the `register()` method
- **Behavior**: 
  - When a student submits the registration form, the system now checks if the **name + matric ID combination** exists in the `student_registry` table
  - If the combination doesn't exist, registration is rejected with error message
  - If valid, the user is created and logged in

### 4. Enhanced Registration Form
- **File**: `resources/views/Register/RegisterView.blade.php`
- **Changes**:
  - Better error messaging for invalid registration attempts
  - Field-level error indicators on Name and MatricNo inputs
  - Clear warning message explaining why registration failed

### 5. New Seeder: `StudentRegistrySeeder`
- **File**: `database/seeders/StudentRegistrySeeder.php`
- **Purpose**: Easily populate the student registry with official student list

## Setup Steps

### Step 1: Run the Migration
```bash
php artisan migrate
```

This creates the `student_registry` table.

### Step 2: Seed the Student Registry
First, edit the seeder to add your official student list:

**File**: `database/seeders/StudentRegistrySeeder.php`

```php
$students = [
    ['MatricNo' => 'CB22001', 'Name' => 'Muhammad Iqmal Hafiy Bin Tajudin', 'Department' => 'Computer Science'],
    ['MatricNo' => 'CB22002', 'Name' => 'Nur Azizah Binti Ahmad', 'Department' => 'Computer Science'],
    ['MatricNo' => 'CB22003', 'Name' => 'Mohd Fahrul Bin Hassan', 'Department' => 'Information Technology'],
    // Add all your students here...
];
```

Then run:
```bash
php artisan db:seed --class=StudentRegistrySeeder
```

Or seed the entire database:
```bash
php artisan db:seed
```

### Step 3: Verify the Setup
1. Go to the registration page
2. Try registering with a name + matric ID that's NOT in the registry
3. You should see: **"Invalid matric number and name combination. Please ensure you enter your correct details as per the official student registry."**

## How It Works

### Registration Flow:
```
Student enters Name + MatricNo + Email + Password
                          ↓
         System validates against student_registry table
                          ↓
    ┌─────────────────────┴────────────────────────┐
    ↓                                              ↓
SUCCESS                                         FAILURE
Registration Complete                    Show error message
Auto-login user                          Redirect to register
```

### Example Scenarios:

#### ✅ Valid Registration
- **Name**: Muhammad Iqmal Hafiy Bin Tajudin
- **MatricNo**: CB22001
- **Result**: Registration succeeds

#### ❌ Invalid - Wrong Name
- **Name**: "Random Student"
- **MatricNo**: CB22001
- **Result**: "Invalid matric number and name combination"

#### ❌ Invalid - Wrong MatricNo
- **Name**: Muhammad Iqmal Hafiy Bin Tajudin
- **MatricNo**: CB99999
- **Result**: "Invalid matric number and name combination"

## Adding/Updating Students

### Method 1: Using the Seeder
Edit `database/seeders/StudentRegistrySeeder.php` and run:
```bash
php artisan db:seed --class=StudentRegistrySeeder
```

### Method 2: Direct Database
```sql
INSERT INTO student_registry (MatricNo, Name, Department, created_at, updated_at) 
VALUES ('CB22006', 'John Doe', 'Computer Science', NOW(), NOW());
```

### Method 3: Create an Admin Upload Feature
You can create a CSV upload feature in the admin panel to bulk import students.

## Important Notes

1. **Name Matching**: The validation is **case-sensitive** and requires **exact match**. Make sure names in the registry match exactly how students enter them.

2. **MatricNo Format**: Store matric numbers in the registry exactly as students will enter them (consider standardizing to uppercase).

3. **Database Import**: If you have an existing CSV with student data, you can bulk import it:
   ```bash
   # Create a script to import from CSV
   php artisan tinker
   >>> \App\Models\StudentRegistry::insert($csvData);
   ```

## Testing

Test these scenarios:
1. ✅ Register with correct name + matric → Success
2. ❌ Register with wrong name + correct matric → Fail
3. ❌ Register with correct name + wrong matric → Fail
4. ❌ Register with fake name + fake matric → Fail
5. ❌ Try registering twice with same matric → Fail (matric already used)

## Files Modified/Created

### New Files:
- `database/migrations/2026_01_19_000000_create_student_registry_table.php`
- `app/Models/StudentRegistry.php`
- `database/seeders/StudentRegistrySeeder.php`

### Modified Files:
- `app/Http/Controllers/AuthController.php`
- `resources/views/Register/RegisterView.blade.php`
- `database/seeders/DatabaseSeeder.php`

## Support
If you need to adjust the validation or add additional fields to the student registry, let me know!
