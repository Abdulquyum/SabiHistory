-- XAMPP MySQL schema for SabiHistory
-- Date: 2026-04-27
-- This copy removes the `CREATE DATABASE` / `USE` statements so it can be imported
-- by a user without global CREATE DATABASE privileges (e.g., phpMyAdmin import).

-- 2) Database privileges are managed outside this dump.
-- If needed, grant access manually after import.

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS lecturer_reviews;
DROP TABLE IF EXISTS ai_sessions;
DROP TABLE IF EXISTS materials;
DROP TABLE IF EXISTS past_questions;
DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS twitter_posts;
DROP TABLE IF EXISTS lecturers;
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS job_batches;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS cache_locks;
DROP TABLE IF EXISTS cache;
DROP TABLE IF EXISTS migrations;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('student', 'lecturer', 'admin') NOT NULL DEFAULT 'student',
  is_admin TINYINT(1) NOT NULL DEFAULT 0,
  matric_no VARCHAR(255) NULL,
  level INT NULL,
  department VARCHAR(255) NOT NULL DEFAULT 'History & Strategic Studies',
  points INT NOT NULL DEFAULT 0,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email),
  UNIQUE KEY users_matric_no_unique (matric_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE migrations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  migration VARCHAR(255) NOT NULL,
  batch INT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE password_reset_tokens (
  email VARCHAR(255) NOT NULL,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sessions (
  id VARCHAR(255) NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  ip_address VARCHAR(45) NULL,
  user_agent TEXT NULL,
  payload LONGTEXT NOT NULL,
  last_activity INT NOT NULL,
  PRIMARY KEY (id),
  KEY sessions_user_id_index (user_id),
  KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache (
  `key` VARCHAR(255) NOT NULL,
  value MEDIUMTEXT NOT NULL,
  expiration BIGINT NOT NULL,
  PRIMARY KEY (`key`),
  KEY cache_expiration_index (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
  `key` VARCHAR(255) NOT NULL,
  owner VARCHAR(255) NOT NULL,
  expiration BIGINT NOT NULL,
  PRIMARY KEY (`key`),
  KEY cache_locks_expiration_index (expiration)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE jobs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  queue VARCHAR(255) NOT NULL,
  payload LONGTEXT NOT NULL,
  attempts TINYINT UNSIGNED NOT NULL,
  reserved_at INT UNSIGNED NULL,
  available_at INT UNSIGNED NOT NULL,
  created_at INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
  id VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  total_jobs INT NOT NULL,
  pending_jobs INT NOT NULL,
  failed_jobs INT NOT NULL,
  failed_job_ids LONGTEXT NOT NULL,
  options MEDIUMTEXT NULL,
  cancelled_at INT NULL,
  created_at INT NOT NULL,
  finished_at INT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  uuid VARCHAR(255) NOT NULL,
  connection TEXT NOT NULL,
  queue TEXT NOT NULL,
  payload LONGTEXT NOT NULL,
  exception LONGTEXT NOT NULL,
  failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lecturers (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  title VARCHAR(255) NULL,
  email VARCHAR(255) NULL,
  phone VARCHAR(255) NULL,
  department VARCHAR(255) NOT NULL DEFAULT 'History & Strategic Studies',
  office_location VARCHAR(255) NULL,
  bio TEXT NULL,
  profile_image VARCHAR(255) NULL,
  average_rating FLOAT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE courses (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  course_code VARCHAR(255) NOT NULL,
  course_title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  level INT NOT NULL,
  semester VARCHAR(255) NOT NULL,
  credits INT NOT NULL DEFAULT 2,
  department VARCHAR(255) NOT NULL DEFAULT 'History & Strategic Studies',
  lecturer_id BIGINT UNSIGNED NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY courses_course_code_unique (course_code),
  KEY courses_lecturer_id_foreign (lecturer_id),
  CONSTRAINT courses_lecturer_id_foreign FOREIGN KEY (lecturer_id) REFERENCES lecturers (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE materials (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  type ENUM('pdf', 'docx', 'image', 'link', 'googledrive') NOT NULL,
  file_path VARCHAR(255) NULL,
  external_url VARCHAR(255) NULL,
  thumbnail VARCHAR(255) NULL,
  course_id BIGINT UNSIGNED NOT NULL,
  uploaded_by BIGINT UNSIGNED NOT NULL,
  level INT NOT NULL,
  downloads INT NOT NULL DEFAULT 0,
  views INT NOT NULL DEFAULT 0,
  upvotes INT NOT NULL DEFAULT 0,
  is_approved TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  KEY materials_course_id_level_index (course_id, level),
  KEY materials_type_index (type),
  KEY materials_uploaded_by_foreign (uploaded_by),
  CONSTRAINT materials_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE,
  CONSTRAINT materials_uploaded_by_foreign FOREIGN KEY (uploaded_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE past_questions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  course_id BIGINT UNSIGNED NOT NULL,
  year INT NOT NULL,
  exam_type VARCHAR(255) NOT NULL DEFAULT 'first_term',
  question_pdf_path VARCHAR(255) NOT NULL,
  solution_pdf_path VARCHAR(255) NULL,
  solution_text TEXT NULL,
  downloads INT NOT NULL DEFAULT 0,
  uploaded_by BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY past_questions_course_id_year_exam_type_unique (course_id, year, exam_type),
  KEY past_questions_uploaded_by_foreign (uploaded_by),
  CONSTRAINT past_questions_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE,
  CONSTRAINT past_questions_uploaded_by_foreign FOREIGN KEY (uploaded_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lecturer_reviews (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  lecturer_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  rating INT NOT NULL,
  comment TEXT NULL,
  course_code VARCHAR(255) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY lecturer_reviews_lecturer_id_user_id_unique (lecturer_id, user_id),
  KEY lecturer_reviews_user_id_foreign (user_id),
  CONSTRAINT lecturer_reviews_lecturer_id_foreign FOREIGN KEY (lecturer_id) REFERENCES lecturers (id) ON DELETE CASCADE,
  CONSTRAINT lecturer_reviews_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ai_sessions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  `query` VARCHAR(255) NOT NULL,
  response TEXT NOT NULL,
  query_type VARCHAR(255) NOT NULL,
  related_material_ids JSON NULL,
  tokens_used INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  KEY ai_sessions_user_id_index (user_id),
  KEY ai_sessions_query_type_index (query_type),
  CONSTRAINT ai_sessions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE news (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) NULL,
  attachment_path VARCHAR(255) NULL,
  attachment_type ENUM('image', 'pdf') NULL,
  source_url VARCHAR(255) NULL,
  category ENUM('academic', 'department', 'university', 'general') NOT NULL DEFAULT 'general',
  posted_by BIGINT UNSIGNED NOT NULL,
  published_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  KEY news_published_at_index (published_at),
  KEY news_posted_by_foreign (posted_by),
  CONSTRAINT news_posted_by_foreign FOREIGN KEY (posted_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE twitter_posts (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  type ENUM('today_history', 'did_you_know') NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255) NULL,
  scheduled_date DATE NOT NULL,
  posted_at TIMESTAMP NULL,
  twitter_post_id VARCHAR(255) NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  UNIQUE KEY twitter_posts_scheduled_date_unique (scheduled_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE projects (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  author_name VARCHAR(255) NOT NULL,
  matric_no VARCHAR(255) NULL,
  department VARCHAR(255) NOT NULL,
  level INT UNSIGNED NULL,
  year_completed INT UNSIGNED NOT NULL,
  abstract TEXT NULL,
  file_path VARCHAR(255) NOT NULL,
  downloads INT UNSIGNED NOT NULL DEFAULT 0,
  uploaded_by BIGINT UNSIGNED NOT NULL,
  is_approved TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (id),
  KEY projects_uploaded_by_foreign (uploaded_by),
  CONSTRAINT projects_uploaded_by_foreign FOREIGN KEY (uploaded_by) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
