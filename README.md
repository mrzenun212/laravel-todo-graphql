# Todo App - Laravel

This is a simple Todo application built with Laravel for the backend and Nuxt.js for the frontend. The backend uses GraphQL to manage tasks, and the frontend uses Vuetify for the UI.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Docker Setup](#docker-setup)
- [API Documentation](#api-documentation)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- Docker installed on your computer
- Docker Compose installed on your computer

## Installation

To set up the project locally, follow these steps:

1. Clone the repository:

```sh
git clone https://github.com/mrzenun212/laravel-todo-graphql
git clone https://github.com/mrzenun212/nuxt-todo-graphql

cd todo-laravel
cp .env.example .env
```

## Usage

### Docker Setup

- To start the project using Docker, follow these steps:

1.	Navigate to the project directory and run:

```sh
docker-compose up --build
```
This command will build and start all the necessary containers.

2.	Access the application:

•	Backend: http://localhost:8082

•	Frontend: http://localhost:3000 - note: sometimes you need to restart the `nuxt_app` server for it locate the graphql endpoint. Just manually restart the container using the Docker Desktop app.

- For logging in, used the following accounts included in the seeder
```
email: user1@example.com
password: user1

email: user2@example.com
password: user2
```


## API Documentation

- The backend uses GraphQL for API communication. You can access the GraphQL playground to test queries and mutations at http://localhost:8082/graphql.

### Example Queries

### Get Tasks
```sh
query {
  tasks {
    id
    name
    state
    user {
      id
      name
      email
    }
  }
}
```

### Create Task
```sh
mutation {
  createTask(name: "New Task") {
    id
    name
    state
    user {
      id
      name
      email
    }
  }
}
```

### Update Task
```sh
mutation {
  updateTask(id: 1, name: "Updated Task", state: true) {
    id
    name
    state
    user {
      id
      name
      email
    }
  }
}
```

### Delete Task
```sh
mutation {
  deleteTask(id: 1) {
    id
    name
    state
    user {
      id
      name
      email
    }
  }
}
```

