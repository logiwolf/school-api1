
# Student Enrollment API Module Documentation

---

##  Base URL

```

[http://localhost:8000/api/v1]

````

---

##  Authentication

### 🧪 Create Admin User (via Laravel Tinker)

Before using the API, create an admin user in Tinker:

```bash
php artisan tinker
````

Then run:

```php
\App\Models\User::create([
    'name' => 'ihusan areef',
    'email' => 'ihsan@example.com',
    'password' => bcrypt('password'), // Always hash passwords!
]);
```

**Example output:**

```php
=> App\Models\User {
    name: "ihusan areef",
    email: "ihsan@example.com",
    password: "$2y$12$ph6uvWdGmToUG23I.QimneLecf8B8rzxoPSr0xAVNDHbwWeOd7t1y",
    updated_at: "2025-07-17 16:58:34",
    created_at: "2025-07-17 16:58:34",
    id: 2,
}
```

---

###  POST `/api/login`

Login and receive a Bearer token.

**Request:**

```json
{
  "email": "ihsan@example.com",
  "password": "password"
}
```

**Response:**

```json

 {
    "token": "your-api-token"
  }

```

Use this token as a Bearer Token in the Authorization header for all protected routes.

---

# 🎓 Student Management

###  POST `/api/v1/students`

Create a new student (admin only)

**Headers:**

```
Authorization: Bearer <your-token>
Content-Type: application/json
```

**Request:**

```json
{
  "name": "Ali Ibrahim",
  "email": "aliibrahim@example.com",
  "birthdate": "2015-01-01",
  "grade": "Grade 2"
}
```

**Response:**

```json
{
    "name": "Ali Ibrahim",
    "email": "aliibrahim@example.com",
    "birthdate": "2015-01-01",
    "grade": "Grade 2",
    "updated_at": "2025-07-17T17:48:39.000000Z",
    "created_at": "2025-07-17T17:48:39.000000Z",
    "id": 3
}
```

---

###  GET `/api/v1/students`

List all students

**Headers:**

```
Authorization: Bearer <your-token>
```

**Response:**

```json
[
    {
        "id": 2,
        "name": "Ali AHmed ibrahim",
        "email": "aliahmed@example.com",
        "birthdate": "2015-01-10",
        "grade": "Grade 2",
        "created_at": "2025-07-17T15:22:26.000000Z",
        "updated_at": "2025-07-17T15:22:26.000000Z",
        "classrooms": [
            { // This will be shown if a student is assigned to the classroom; otherwise, the array will be empty.
                "id": 1,
                "name": "Grade 3",
                "section": "A",
                "max_students": 30,
                "created_at": "2025-07-17T15:23:29.000000Z",
                "updated_at": "2025-07-17T15:23:29.000000Z",
                "pivot": {
                    "student_id": 2,
                    "classroom_id": 1
                } 
            }
        ]
    },
    ...
]
```

---

###  PUT `/api/v1/students/{studentid}`

Update student information

**Headers:**

```
Authorization: Bearer <your-token>
Content-Type: application/json
```

**Request:**

```json
{
  "name": "Ali Shameem Updated",
  "email": "aliupdated@example.com",
  "birthdate": "2015-01-01",
  "grade": "Grade 3"
}
```

**Response:**

```json
{
    "message": "Student updated successfully",
    "data": {
        "id": 2,
        "name": "Ali Shameem Updated",
        "email": "aliupdated@example.com",
        "birthdate": "2015-01-01",
        "grade": "Grade 3",
        "created_at": "2025-07-17T15:22:26.000000Z",
        "updated_at": "2025-07-17T17:52:33.000000Z"
    }
}
```

---

###  DELETE `/api/v1/students/{studentid}`

Delete a student (admin only)

**Headers:**

```
Authorization: Bearer <your-token>
```

**Response:**

```json
{
  "message": "Student deleted successfully"
}
```

---

#  Classroom Management

###  POST `/api/v1/classrooms`

Create a new classroom (admin only)

### must have a student to create a classroom

**Headers:**

```
Authorization: Bearer <your-token>
Content-Type: application/json
```

**Request:**

```json
{
  "name": "Class A",
  "section": "A1",
  "max_students": 30,
  "student_ids": [2]   // Optional: assign students at creation
}
```

**Response:**

```json
{
    "message": "Classroom created successfully",
    "data": {
        "name": "Class A",
        "section": "A1",
        "max_students": 30,
        "updated_at": "2025-07-17T18:06:52.000000Z",
        "created_at": "2025-07-17T18:06:52.000000Z",
        "id": 2,
        "students": [
            {
                "id": 2,
                "name": "Ali Student",
                "email": "ali@example.com",
                "birthdate": "2015-01-01",
                "grade": "Grade 2",
                "created_at": "2025-07-17T17:16:51.000000Z",
                "updated_at": "2025-07-17T17:16:51.000000Z",
                "pivot": {
                    "classroom_id": 2,
                    "student_id": 2
                }
            }
        ]
    }
}
```

---

###  GET `/api/v1/classrooms`

List all classrooms with their students

**Headers:**

```
Authorization: Bearer <your-token>
```

**Response:**

```json
{
    "data": [
        ...
        {
            "id": 2,
            "name": "Class A",
            "section": "A1",
            "max_students": 30,
            "created_at": "2025-07-17T18:06:52.000000Z",
            "updated_at": "2025-07-17T18:06:52.000000Z",
            "students": [
                {
                    "id": 2,
                    "name": "Ali Student",
                    "email": "ali@example.com",
                    "birthdate": "2015-01-01",
                    "grade": "Grade 2",
                    "created_at": "2025-07-17T17:16:51.000000Z",
                    "updated_at": "2025-07-17T17:16:51.000000Z",
                    "pivot": {
                        "classroom_id": 2,
                        "student_id": 2
                    }
                }
            ]
        }
      ...
    ]
}
```

---

###  PUT `/api/v1/classrooms/{classroomID}`

Update classroom details

**Headers:**

```
Authorization: Bearer <your-token>
Content-Type: application/json
```

**Request:**

```json
{
  "name": "Class A Updated",
  "section": "A1",
  "max_students": 35
}
```

**Response:**

```json
{
    "message": "Classroom updated successfully",
    "data": {
        "id": 2,
        "name": "Class A Updated",
        "section": "A1",
        "max_students": 35,
        "created_at": "2025-07-17T18:06:52.000000Z",
        "updated_at": "2025-07-17T18:11:02.000000Z"
    }
}
```

---

###  POST `/api/v1/classrooms/{classroom}/assign`

Assign a student to a classroom

**Headers:**

```
Authorization: Bearer <your-token>
Content-Type: application/json
```

**Request:**

```json
{
  "student_id": 1
}
```

**Response Success:**

```json
{
  "message": "Student assigned successfully to the classroom."
}
```

**Response Failure (if class full):**

```json
{
    "message": "Student assigned successfully to the classroom."
}
```

---

###  DELETE `/api/v1/classrooms/{classroom}`

Delete a classroom

**Headers:**

```
Authorization: Bearer <your-token>
```

**Response:**

```json
{
  "message": "Classroom deleted successfully"
}
```

---

#  Notes

* All `/api/v1/*` routes are protected and require authentication via Sanctum Bearer token.
* Only users with the **admin** role can access these endpoints.
* Validation errors return status code **422 Unprocessable Entity**.
* Classroom assignment checks for maximum capacity before adding students.

---

#  Testing

Run your tests with:

```bash
php artisan test
```

```
PASS  Tests\Unit\ClassAssignmentUnitTest
  ✓ student can be assigned to classroom                                                
  ✓ student can be assigned to multiple classrooms                                     
   PASS  Tests\Feature\StudentFeatureTest
  ✓ admin can create student
```
---

Created by :Ihusaan Areef, ihusaanareef@gmail.com
```
