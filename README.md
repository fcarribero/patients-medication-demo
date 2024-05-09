# How to run it

```php run_test.php "mysql:host=localhost;dbname=database;user=dbusername;password=dbpassword"```

# Output
```
Get all patients that are taking one particular medication
------------------------------- | ---------------
patient_name                    | medication_name
------------------------------- | ---------------
Betty Boop                      | Giggletrex
Princess Consuela Bananahammock | Giggletrex


Get all patients and prescriptions count for current year ordered by
------------------------------- | -------------
name                            | prescriptions
------------------------------- | -------------
Princess Consuela Bananahammock | 2
Betty Boop                      | 1
Harry Potter                    | 1
Chuck Norris                    | 1
Whoopsy Goldberg                | 1


Get all medications for one particular patient
------------------------------- | ------------------ | --------------- | ------- | -------- | --------------- | ---------- | ----------
patient_name                    | doctor_name        | medication_name | dose    | quantity | frequency_hours | start_by   | end_by
------------------------------- | ------------------ | --------------- | ------- | -------- | --------------- | ---------- | ----------
Princess Consuela Bananahammock | Dr. Christina Yang | Smilenex        | 7500mg  | 5        | 6               | 2021-05-01 | 2022-08-20
Princess Consuela Bananahammock | Dr. Christina Yang | Giggletrex      | 10000mg | 1        | 6               | 2021-06-01 | 2022-09-20


Get all patients that prescribed more than one medication for the previous and current year
-------------------------------
name
-------------------------------
Princess Consuela Bananahammock
```

### Things to consider

- The script was developed using PHP 7.4
- The script will create all the tables in the database if they don't exist.
- Dummy data is located in the `inc/misc.php` file