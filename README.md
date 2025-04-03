# First Quiz

This is the second website I developed, designed to practice Vue.js and learn Vuex. The site is built using Vue.js and Laravel, utilizing Inertia.js to create a Single Page Application (SPA). While the primary focus was on functionality and learning, the visual design is minimal.

## Features

- **Single Page Application (SPA):** Built with Vue.js and Laravel.
- **State Management:** Utilizes Vuex for efficient state management.
- **Server-Side Rendering:** Implements Inertia.js for seamless server-client interaction.

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/SAMoosavi/first-quiz.git
   cd first-quiz
   ```

2. **Install backend dependencies:**

   ```bash
   composer install
   ```

3. **Install frontend dependencies:**

   ```bash
   npm install
   ```

4. **Set up the environment:**

   - Duplicate the `.env.example` file and rename it to `.env`.
   - Configure your database and other environment settings in the `.env` file.

5. **Generate application key:**

   ```bash
   php artisan key:generate
   ```

6. **Run database migrations:**

   ```bash
   php artisan migrate
   ```

7. **Build assets:**

   ```bash
   npm run dev
   ```

8. **Start the development server:**

   ```bash
   php artisan serve
   ```

   The application will be accessible at `http://localhost:8000`.

## Usage

After setting up the project, you can access the quiz application in your browser. The application allows users to take quizzes, with state management handled by Vuex and seamless page transitions facilitated by Inertia.js.
