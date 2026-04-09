# App Store Clean Architecture API

This project is a robust, clean-architecture based API constructed with **Symfony 7.4** and **PHP 8.2+**. The primary objective of this repository is to serve as a comprehensive example or boilerplate of how to implement Domain-Driven Design (DDD) principles and Clean Architecture (Ports and Adapters) in a modern Symfony environment.

## 🚀 Tech Stack

- **Framework**: Symfony 7.4
- **Language**: PHP 8.2 or higher
- **Database**: PostgreSQL 16 (via Docker)
- **ORM**: Doctrine ORM (^3.6)
- **Authentication**: JWT via LexikJWTAuthenticationBundle
- **Static Analysis**: PHPStan

## 🏗 Architecture

The codebase strictly adheres to **Clean Architecture** patterns, ensuring the separation of concerns, high testability, and independence from frameworks and external services.

The system is split into multiple independent layers:

### 1. Domain (`src/Domain`)

The core of the application. It contains the business logic, enterprise rules, and the most critical structures of the system.

- **Entities**: Business objects like `Product` or `User`.
- **Value Objects**: Immutable objects that represent descriptive aspects of the domain.
- **Repositories Interfaces**: Interfaces defining how Domain data interacts with persistence, without implementing the physical operations.
- _Dependencies_: Has zero external dependencies (no Symfony components or Doctrine attributes).

### 2. Application (`src/Application`)

Coordinates the application's use cases. It orchestrates the domain layer objects to perform specific tasks.

- **Use Cases (Services)**: E.g., `CreateProduct`, `LoginUser`. They implement specific rules of the application.
- **DTOs (Data Transfer Objects)**: Carry data between processes to reduce the number of method calls and decouple HTTP from strict domain constraints.
- **Mappers**: Transform DTOs into Domain Entities and vice-versa.

### 3. Infrastructure (`src/Infrastructure`)

The outermost layer. It contains the concrete implementations of interfaces defined in the Domain and the integration with external tools (Symfony, Doctrine, HTTP).

- **Controllers**: Entry points for the API. They receive HTTP requests, dispatch execution to Use Cases, and return matching HTTP responses.
- **Persistence**: Doctrine ORM entities/repositories maps and actual DB query logic.
- **Security**: Specifics to Symfony security firewalls and Lexik JWT operations.
- **Http Integrations**: Resolvers (like `RequestDtoResolver`), exception handlers (`ApiExceptionListener`), etc.

## 🛡 Best Practices & Patterns Applied

- **Dependency Inversion Principle (SOLID)**: Use Cases and Controllers depend on interfaces, while Infrastructure implements them.
- **Unit of Work Pattern**: Database transactions are efficiently managed at the Application layer across multiple Repositories. Persistence (`save`/`remove`) is decoupled from database commits (`flush()`), guaranteeing atomicity and reducing I/O latency inside Use Cases.
- **CQRS Mindset**: Separation of read operations (Queries) and write operations (Commands/Use Cases).
- **Global Exception Handling**: Dedicated `ApiExceptionListener` mapped in Infrastructure to gracefully capture and format exceptions into uniform JSON API responses.
- **Automatic DTO Mapping**: `RequestDtoResolver` injects validated request bodies directly into controller actions enforcing declarative structural typing.
- **Migrations & Fixtures**: Ensuring reproducible database states locally and globally.

## ⚙️ Prerequisites

To run this application locally, you will need:

- [Docker](https://www.docker.com/) & Docker Compose
- [PHP 8.2+](https://www.php.net/downloads) setup locally (CLI)
- [Composer](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download) (Recommended for a fast locale setup)

## 🛠 Installation & Setup

1. **Clone the repository**

    ```bash
    git clone https://github.com/leoerickp/symfony_backend_api_clean_architecture.git
    cd app-store-clean-arch
    ```

2. **Spin up the database container (Postgres)**

    ```bash
    docker compose up -d
    ```

    _This starts up a Postgres 16 instance with the configuration defined in `compose.yaml`._

3. **Install PHP dependencies**

    ```bash
    composer install
    ```

4. **Setup Environment Variables**
   If it wasn't duplicated automatically, copy `.env` to `.env.local`:

    ```bash
    cp .env .env.local
    ```

    _(Ensure your database URL is correctly pointing to localhost since we spin up the DB with docker but run code via Symfony CLI)._

5. **Generate JWT SSL Keys**
   The application secures routes using JWT. Generate the cryptographic keys:

    ```bash
    php bin/console lexik:jwt:generate-keypair
    ```

6. **Run Database Migrations**

    ```bash
    php bin/console doctrine:migrations:migrate --no-interaction
    ```

    _(Optional)_ If fixtures are available, load up mock data:

    ```bash
    php bin/console doctrine:fixtures:load --no-interaction
    ```

7. **Start the Symfony Local Server**
    ```bash
    symfony server:start -d
    ```

## 🧪 Useful Commands

- **Clear Cache:**
    ```bash
    php bin/console cache:clear
    ```
- **Stop local server:**
    ```bash
    symfony server:stop
    ```
- **Stop Docker containers:**
    ```bash
    docker compose down
    ```
