# Taskette

Taskette is a task management web application built with **PHP** following the **Model–View–Controller (MVC)** architectural pattern.

The project was developed as part of my PHP Full Stack course to practice object-oriented programming, backend architecture, frontend development, responsive interfaces, JSON persistence, and GitFlow.

---

# Features

* Create new tasks
* List all tasks
* View task details
* Edit task titles
* Delete tasks
* Manage the task lifecycle:

  * Start
  * Complete
  * Reset
  * Restart
* Persist data using a JSON file
* Responsive user interface built with Tailwind CSS

---

# Task Lifecycle

Each task can move through the following states:

```text
Pending
   │
   ▼
Started
   │
   ▼
Completed
```

Additional supported transitions:

* **Reset** → Started → Pending
* **Restart** → Completed → Started

The business rules ensure that only valid task state transitions are allowed.

---

# Task Information

Each task stores:

* ID
* Title
* Current state
* Start timestamp
* Completion timestamp
* Creator identifier

---

# Architecture

Taskette follows the **Model–View–Controller (MVC)** architectural pattern.

```text
Browser
   │
   ▼
Controller
   │
   ▼
Model
   │
   ▼
View
```

## Controller

The controllers receive incoming requests, **normalize and validate user input**, coordinate the application flow, invoke the appropriate business logic, and select the view to render.

## Model

The Model layer is responsible for representing the application's domain, implementing business rules, and managing persistence.

To keep responsibilities separated, it is internally divided into:

* **Domain Models** – represent the application's entities (`Task`)
* **Services** – implement business rules and task state transitions
* **Repositories** – handle persistence by reading and writing the JSON storage

## View

Views are built using **PHTML** templates.

They are responsible for presenting the data provided by the controllers without containing business logic. Styling is implemented using **Tailwind CSS**.

---

# Project Structure

```text
app/
├── controllers/
├── models/
├── views/

config/
data/
lib/
web/
```

* **controllers** – Request handling
* **models** – Domain models, services, repositories, enums
* **views** – PHTML templates
* **config** – Routing and configuration
* **data** – JSON persistence
* **lib** – Base framework classes
* **web** – Front controller and static assets

---

# Routes

| Route          | Description                    |
| -------------- | ------------------------------ |
| `/task/new`    | Display the task creation form |
| `/task/create` | Create a new task              |
| `/task/list`   | Display all tasks              |
| `/task/show`   | Display task details           |
| `/task/edit`   | Display the edit form          |
| `/task/save`   | Save task edits                |
| `/task/update` | Update the task state          |
| `/task/delete` | Delete a task                  |

---

# Tech Stack

## Backend

* PHP
* MVC Architecture
* Object-Oriented Programming
* Service / Repository pattern
* JSON persistence

## Frontend

* PHTML templates
* Tailwind CSS
* Responsive design

## Development

* Git
* GitFlow

---

# Design

The interface was built with **Tailwind CSS**, following a clean and responsive design. Reusable utility classes and custom component classes are used to provide a consistent appearance across forms, cards, buttons, notifications, and task views.

---

# Requirements

* PHP 8.x
* Apache, Nginx, or another PHP-compatible web server

No database configuration is required.

---

# Running the Project

1. Clone the repository.
2. Configure your web server to serve the project's `web/` directory.
3. Ensure the `data/tasks.json` file is writable by the PHP process.
4. Open the application in your browser.

Example using XAMPP:

```text
http://localhost/php-s03-03-to-do/web/
```

---

# Data Persistence

Taskette stores its data in:

```text
data/tasks.json
```

The application does not require a relational database. All task information is loaded from and saved to the JSON file through the Repository layer.

---

# Learning Objectives

This project was developed to practice:

* PHP application development
* MVC architecture
* Object-Oriented Programming
* Separation of concerns
* Service and Repository patterns
* Frontend development with PHTML templates
* Responsive UI development with Tailwind CSS
* JSON-based persistence
* GitFlow workflow
