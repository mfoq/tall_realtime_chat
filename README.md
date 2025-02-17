# Real-Time Chat Application

This is a simple real-time chat application built using Laravel 11, Livewire 3, Alpine.js 3, Tailwind, Pusher, and Laravel Echo and Queues. The application is designed for real-time messaging with read receipts (single tick for sent, double tick for read) without requiring page refreshes. Laravel Breeze is used as the authentication starter kit.

## Features

- **Real-time messaging** using Pusher and laravel echo.
- **Livewire-powered UI** for dynamic, reactive updates.
- **Read receipts** with single and double ticks.
- **Queue processing** for handling background jobs efficiently.
- **Alpine.js 3** for lightweight frontend interactions.
- **Authentication** with Laravel Breeze.

## Installation

### Prerequisites
Ensure you have the following installed:
- PHP 8.3+
- Composer
- Node.js & NPM
- Database (for queues)
- Pusher account & API credentials
- MySQL database

### Setup
1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-repo/realtime-chat.git
   cd realtime-chat
   ```

2. **Install dependencies:**
   ```sh
   composer install
   npm install && npm run build
   ```

3. **Set up environment variables:**
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your database and Pusher credentials:
   ```env
   PUSHER_APP_ID=your-app-id
   PUSHER_APP_KEY=your-app-key
   PUSHER_APP_SECRET=your-app-secret
   PUSHER_APP_CLUSTER=your-cluster
   BROADCAST_CONNECTION=pusher
   QUEUE_CONNECTION=database
   ```

4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

5. **Run migrations and seed the database:**
   ```sh
   php artisan migrate --seed
   ```

6. **Set up queue worker:**
   ```sh
   php artisan queue:work
   ```
7. **Start the application:**
   ```sh
   php artisan serve
   ```

8. **Start Pusher listener (if needed for debugging):**
   ```sh
   php artisan pusher:listen
   ```

## Usage

- Register/Login using Laravel Breeze authentication.
- Send messages in real time without refreshing the page.
- Messages show a **single tick** when sent and **double ticks** when read.
- Background job queues handle message broadcasting efficiently.

## Architecture

- **Backend:** Laravel 11
- **Frontend:** Livewire 3 & Alpine.js 3 , Tailwind 3
- **Real-time events:** Pusher
- **Queues:** Laravel Queues
- **Authentication:** Laravel Breeze

## Troubleshooting

- Ensure your `.env` is configured correctly with the right Pusher credentials.
- Run `php artisan queue:work` in a separate terminal to process jobs.
- If real-time updates are not working, verify that your Pusher settings are correct.
- Check browser console and Laravel logs for any errors:
  ```sh
  php artisan logs:tail
  ```

