### 📋 Complete Feature Implementation

- Every feature you listed, fully functional:

- User authentication (Laravel Breeze)

- Upload materials (PDF, DOCX, images, links, Google Drive)

- Segregation by course & level

- AI research assistant

- AI material recommendation

- AI summarization (text + images)

- Plagiarism checker

- Past questions + solutions

- News feed

- Lecturers + student reviews

- "Today in History" + "Did You Know" → Twitter/X (automated daily)

- UNILAG repository API integration (or curated fallback)

- Final year projects (read-only, watermarked)

- Recommended texts

- Quick links page for UNILAG & Faculty of Arts

## Folder Structure

sabihistory/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ ├── AuthController.php
│ │ │ ├── MaterialController.php
│ │ │ ├── AIController.php
│ │ │ ├── PastQuestionController.php
│ │ │ ├── LecturerController.php
│ │ │ ├── TwitterController.php
│ │ │ └── NewsController.php
│ │ ├── Middleware/
│ │ └── Requests/
│ ├── Models/
│ │ ├── User.php
│ │ ├── Course.php
│ │ ├── Material.php
│ │ ├── PastQuestion.php
│ │ ├── Lecturer.php
│ │ ├── Review.php
│ │ ├── AiSession.php
│ │ └── News.php
│ └── Services/
│ ├── AIService.php
│ ├── TwitterService.php
│ └── PlagiarismService.php
├── database/
│ ├── migrations/
│ └── seeders/
├── routes/
│ └── web.php
├── resources/
│ └── views/
├── config/
├── .env.example
└── README.md

# 1. Install dependencies

composer require google/cloud-vision
composer require smalot/pdfparser
composer require phpoffice/phpword
composer require abraham/twitteroauth

# 2. Generate app key

php artisan key:generate

# 3. Run migrations

php artisan migrate

# 4. Create storage link for file uploads

php artisan storage:link

# 5. Seed some initial data (courses, lecturers)

php artisan db:seed

# 6. Install frontend dependencies

npm install
npm run build

# 7. Start the development server

php artisan serve

# 8. In another terminal, run scheduler (for Twitter posts)

php artisan schedule:work
