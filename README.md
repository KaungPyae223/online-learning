# Online Course API Documentation

**Base URL**

    http://127.0.0.1:8000/api

## Category

Category for course

|End point|Method|Description|
|--|--|--|
|/category| GET | Get all category data
|/category| POST | Create category
|/category/{id}| PUT | Update category data
|/category/{id}| Delete | Delete category data

**Get category** 

Sample Output Data

    {

    "data": [
    
    {
    
	    "id": 1,
	    
	    "category": "word press",
	    
	    "created_at": "2024-12-03T09:52:00.000000Z",
	    
	    "updated_at": "2024-12-03T09:52:00.000000Z"
    
    },
    
    {
    
	    "id": 2,
	    
	    "category": "Basic Java Script",
	    
	    "created_at": "2024-12-03T09:52:16.000000Z",
	    
	    "updated_at": "2024-12-03T09:52:16.000000Z"
    
    },
    
    {
    
	    "id": 3,
	    
	    "category": "React and Laravel",
	    
	    "created_at": "2024-12-03T09:52:29.000000Z",
	    
	    "updated_at": "2024-12-03T09:52:29.000000Z"
    
    }
    
    ],
    
    "status": 200
    
    }


**Create Category**
| Key | Type | Status |Description |
|--|--|--|--|
| category | string | required |


## Course

Course is for the online course data.

**End Point**

|End point|Method|Description|
|--|--|--|
|/course| GET | Get all course data
|/course| POST | Create course data
|/course/{id}| GET | Get specific course data
|/course/{id}| PUT | Update course data
|/course/{id}| Delete | Delete course data

**Get course** 

Sample Output Data

  

    {
    
	    "data": [
	    
	    {
		    
		    "id": 1,
		    
		    "course_name": "Advanced web design",
		    
		    "course_image": "ABCD",
		    
		    "total_student": 5,
		    
		    "price": 300,
		    
		    "total_duration": "2hr 0min",
		    
		    "total_lessons": 3,
		    
		    "average_rating": 4.2,
		    
		    "category": "React and Laravel",
		    
		    "level": "Advanced",
		    
		    "language": "Spanish",
		    
		    "instructor_name": "Michael Lee",
		    
		    "instructor_profile": "michael_lee.jpg"
	    
	    },
	    
	    {
	    
		    "id": 3,
		    
		    "course_name": "Japanese Language",
		    
		    "course_image": "http://127.0.0.1:8000/images/Course_image_674fca908b16a.png",
		    
		    "total_student": 0,
		    
		    "price": 35000,
		    
		    "total_duration": "0hr 0min",
		    
		    "total_lessons": 0,
		    
		    "average_rating": 0,
		    
		    "category": "word press",
		    
		    "level": "Intermediate",
		    
		    "language": "English",
		    
		    "instructor_name": "John Doe",
		    
		    "instructor_profile": "john_doe.jpg"
	    
	    }
	    
	    ],
	    
	    "status": 200
    
    }



**Create course data**

| Key | Type | Status |Description |
|--|--|--|--|
| name | string | required |
| info | string | required |
| price | integer | required |
| description | string | required |
| can_learn | string[] | required |
| skill_gain | string[] | required |
| category_id | integer | required |
| level_id | integer | required |
| language_id | integer | required |
| instructor_id | integer | required |
| course_image | image | required | available only [ jpeg, png, jpg, gif ] and maximum image size should be 2 Mb |

**Get Specisfic Course**

Sample output

   

     {
    
	    "data": {
	    
		    "id": 1,
		    
		    "course_name": "Advanced web design",
		    
		    "total_student": 5,
		    
		    "price": 300,
		    
		    "description": "ABCD",
		    
		    "info": "ABCD",
		    
		    "can_learn": [
		    
			    "ABC",
			    
			    "DEF",
			    
			    "GHI"
		    
		    ],
		    
		    "skill_gain": [
		    
			    "ABC",
			    
			    "DEF",
			    
			    "GHI"
		    
		    ],
		    
		    "total_duration": "2hr 0min",
		    
		    "total_lessons": 3,
		    
		    "average_rating": 4.2,
		    
		    "category": "React and Laravel",
		    
		    "level": "Advanced",
		    
		    "language": "Spanish",
		    
		    "curriculum": [
		    
			    {
			    
				    "curriculum_name": "HTML, CSS, Java Script, React",
				    
				    "total_lessons": 3,
				    
				    "lessons": [
				    
				    {
				    
					    "lesson_name": "What is CSS",
					    
					    "video": "ABCD",
					    
					    "duration": "2hr 0min"
				    
				    },
			    
				    {
			    
					    "lesson_name": "What is HTML",
					    
					    "video": "http://127.0.0.1:8000/videos/Course_video_674fd1d77a466.mp4",
					    
					    "duration": "0hr 0min"
				    
				     },
				    
					 {
				    
					    "lesson_name": "what is css",
					    
					    "video": "http://127.0.0.1:8000/videos/Course_video_674fda7795291.mp4",
					    
					    "duration": "0hr 0min"
				    
					  }
				    
				    ]
			    
			    }
		    
		    ],
		    
		    "instructor": {
		    
			    "instructor_name": "Michael Lee",
			    
			    "instructor_type": "meditation",
			    
			    "instructor_photo": "michael_lee.jpg",
			    
			    "X": "https://twitter.com/michaellee",
			    
			    "facebook": "https://facebook.com/michaellee",
			    
			    "instagram": "https://instagram.com/michaellee",
			    
			    "linkedIn": "https://linkedin.com/in/michaellee",
			    
			    "total_instructor_courses": 1,
			    
			    "total_instructor_students": 5,
			    
			    "instructor_rating": 4.2
		    
		    },
		    
		    "reviews": {
		    
			    "rating_count": {
			    
				    "5_stars": 100,
				    
				    "4_stars": 100,
				    
				    "3_stars": 50,
				    
				    "2_stars": 0,
				    
				    "1_stars": 0
				    
			    },
			    
			    "review_data": [
			    
				    {
					    
					    "reviewer_name": "Alice Johnson",
					    
					    "reviewer_profile": "alice.jpg",
					    
					    "review_content": "Great course! Learned a lot.",
					    
					    "rating": 5,
					    
					    "review_date": "2024-12-03T08:30:00.000000Z"
					    
				    },
				    
				    {
					    
					    "reviewer_name": "Bob Smith",
					    
					    "reviewer_profile": "bob.jpg",
					    
					    "review_content": "Amazing content and instructor.",
					    
					    "rating": 5,
					    
					    "review_date": "2024-12-03T08:35:00.000000Z"
					    
				    },
				    
				    {
					    
					    "reviewer_name": "Carol White",
					    
					    "reviewer_profile": "carol.jpg",
					    
					    "review_content": "Very helpful, but some topics could be clearer.",
					    
					    "rating": 4,
					    
					    "review_date": "2024-12-03T08:40:00.000000Z"
					    
				    },
				    
				    {
					    
					    "reviewer_name": "David Brown",
					    
					    "reviewer_profile": "david.jpg",
					    
					    "review_content": "Fantastic course! Highly recommend.",
					    
					    "rating": 4,
					    
					    "review_date": "2024-12-03T08:45:00.000000Z"
					    
				    },
				    
				    {
				    
					    "reviewer_name": "Eve Davis",
					    
					    "reviewer_profile": "eve.jpg",
					    
					    "review_content": "Good course, but needs more examples.",
					    
					    "rating": 3,
					    
					    "review_date": "2024-12-03T08:50:00.000000Z"
					    
				    }
			    
			    ]
			    
		    },
		    
		    "faqs": [
		    
			    {
			    
				    "question": "What is this course about?",
				    
				    "answer": "This course covers advanced web design techniques."
			    
			    },
			    
			    {
			    
				    "question": "Who is this course for?",
				    
				    "answer": "This course is designed for intermediate to advanced learners."
			    
			    },
			    
			    {
			    
				    "question": "Are there any prerequisites?",
				    
				    "answer": "Basic knowledge of HTML, CSS, and JavaScript is recommended."
			    
			    },
			    
			    {
			    
				    "question": "How long does it take to complete?",
				    
				    "answer": "The course takes approximately 6 weeks to complete."
			    
			    },
			    
			    {
			    
				    "question": "Is there a certificate provided?",
				    
				    "answer": "Yes, a certificate is provided upon successful completion."
			    
			    }
		    
		    ]
	    
	    },
	    
	    "status": 200
    
    }
## Curricula

Curricula is a course's curricula.

**End Point**

|End point|Method|Description|
|--|--|--|
|/curricula| GET | Get all curriculum data
|/curricula| POST | Create curriculum data
|/curricula/{id}| PUT | Update curriculum data
|/curricula/{id}| Delete | Delete curriculum data

**Get Curricula** 

Sample Output Data

   

     {
    
	    "data": [
	    
		    {
		    
			    "id": 1,
			    
			    "curriculum_name": "HTML, CSS, Java Script, React",
			    
			    "course_id": 1,
			    
			    "created_at": "2024-12-03T10:02:37.000000Z",
			    
			    "updated_at": "2024-12-03T10:08:07.000000Z"
			    
		    }
	    
	    ],
	    
	    "status": 200
	    
    }

**Create Curricula** 
| Key | Type | Status |Description |
|--|--|--|--|
| curriculum_name | string | required |

## Lesson

Lessons for curricula

**End Point**

|End point|Method|Description|
|--|--|--|
|/lesson| GET | Get all lesson data
|/lesson| POST | Create lesson data
|/lesson/{id}| PUT | Update lesson data
|/lesson/{id}| Delete | Delete lesson data

**Get all lessons**

Sample Output data

    {
    
	    "data": [
	    
		    {
		    
			    "id": 1,
			    
			    "curriculum_id": 1,
			    
			    "lesson_name": "What is CSS",
			    
			    "video": "ABCD",
			    
			    "duration": 120,
			    
			    "created_at": "2024-12-03T10:28:48.000000Z",
			    
			    "updated_at": "2024-12-03T10:31:12.000000Z"
		    
		    },
		    
		    {
		    
			    "id": 2,
			    
			    "curriculum_id": 1,
			    
			    "lesson_name": "What is HTML",
			    
			    "video": "http://127.0.0.1:8000/videos/Course_video_674fd1d77a466.mp4",
			    
			    "duration": 0,
			    
			    "created_at": "2024-12-04T03:51:51.000000Z",
			    
			    "updated_at": "2024-12-04T03:51:51.000000Z"
			    
		    },
	   
	    
	    ],
	    
	    "status": 200
    
    }

**Create Lesson**
| Key | Type | Status |Description |
|--|--|--|--|
| curriculum_id | integer | required |
| video | video | required | available only [ mp4,avi,mov,mkv ] and maximum video size should be 500 Mb |

