# Database Files

This folder contains all SQL files for the GOSTUDENT project.

## Files Overview

### 1. db.sql
**Purpose**: Main database schema
**Use**: Initial database setup
**Contains**:
- All table structures
- Primary keys and foreign keys
- Indexes
- Table relationships

**When to use**: First time setup or fresh installation

```bash
mysql -u root -p student_portal < database/db.sql
```

---

### 2. student_portal.sql
**Purpose**: Complete database dump
**Use**: Full backup with schema and data
**Contains**:
- Database schema
- All table structures
- Sample data (if any)

**When to use**: Restoring complete database or migration

```bash
mysql -u root -p < database/student_portal.sql
```

---

### 3. quick_sample_data.sql
**Purpose**: Quick sample data for testing
**Use**: Add sample content to existing database
**Contains**:
- 5 Assignments
- 3 Quizzes (9 questions total)
- 8 Notices

**Requirements**: 
- Database schema already created
- At least one teacher account (teacher_id = 1)

**When to use**: Quick testing with sample data

```bash
mysql -u root -p student_portal < database/quick_sample_data.sql
```

**Note**: If your teacher_id is not 1, edit the file and replace all `teacher_id, 1` with your actual teacher ID.

---

### 4. sample_data.sql
**Purpose**: Complete sample data with users
**Use**: Full demo setup with users and content
**Contains**:
- 1 Teacher account (username: teacher1, password: password123)
- 3 Student accounts (username: student1-3, password: password123)
- 5 Detailed assignments
- 4 Quizzes (20 questions total)
- 8 Notices

**When to use**: Demo environment or testing with pre-made users

```bash
mysql -u root -p student_portal < database/sample_data.sql
```

**Login Credentials**:
- Teacher: `teacher1` / `password123`
- Students: `student1`, `student2`, `student3` / `password123`

---

### 5. truncate_tables.sql
**Purpose**: Clear all data from tables
**Use**: Reset database to empty state
**Contains**:
- TRUNCATE statements for all tables
- Preserves table structure
- Removes all data

**When to use**: 
- Starting fresh with clean database
- Removing test data
- Before importing new data

**⚠️ WARNING**: This will delete ALL data!

```bash
mysql -u root -p student_portal < database/truncate_tables.sql
```

---

## Setup Guide

### Fresh Installation

1. **Create Database**:
```sql
CREATE DATABASE student_portal;
```

2. **Import Schema**:
```bash
mysql -u root -p student_portal < database/db.sql
```

3. **Add Sample Data** (Optional):
```bash
mysql -u root -p student_portal < database/quick_sample_data.sql
```

### Using phpMyAdmin

1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create database: `student_portal`
3. Select the database
4. Go to "Import" tab
5. Choose file: `database/db.sql`
6. Click "Go"
7. (Optional) Import `database/quick_sample_data.sql` for sample data

---

## File Comparison

| File | Size | Users | Content | Use Case |
|------|------|-------|---------|----------|
| **db.sql** | 12 KB | No | Schema only | Fresh install |
| **student_portal.sql** | 22 KB | Maybe | Full dump | Backup/Restore |
| **quick_sample_data.sql** | 3 KB | No | Sample data | Quick test |
| **sample_data.sql** | 11 KB | Yes | Users + Data | Full demo |
| **truncate_tables.sql** | 2 KB | No | Clear data | Reset |

---

## Common Tasks

### Start Fresh
```bash
# 1. Drop and recreate database
mysql -u root -p -e "DROP DATABASE IF EXISTS student_portal; CREATE DATABASE student_portal;"

# 2. Import schema
mysql -u root -p student_portal < database/db.sql

# 3. Add sample data
mysql -u root -p student_portal < database/quick_sample_data.sql
```

### Clear All Data
```bash
mysql -u root -p student_portal < database/truncate_tables.sql
```

### Backup Database
```bash
mysqldump -u root -p student_portal > database/backup_$(date +%Y%m%d).sql
```

### Restore Backup
```bash
mysql -u root -p student_portal < database/backup_20241213.sql
```

---

## Troubleshooting

### "Table already exists"
**Solution**: Drop database and recreate
```sql
DROP DATABASE student_portal;
CREATE DATABASE student_portal;
```

### "Foreign key constraint fails"
**Solution**: Import in correct order (db.sql first, then sample data)

### "Access denied"
**Solution**: Check MySQL credentials in `includes/db.php`

### "Unknown database"
**Solution**: Create database first
```sql
CREATE DATABASE student_portal;
```

---

## Notes

- All SQL files use UTF-8 encoding
- Compatible with MySQL 5.7+ and MariaDB 10.2+
- Foreign key constraints are enabled
- InnoDB engine is used for all tables
- Auto-increment values are preserved

---

## Support

For issues or questions:
1. Check the main README.md
2. Review CHANGELOG.md for recent changes
3. Verify database credentials in `includes/db.php`

---

**Last Updated**: December 13, 2024
