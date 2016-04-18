DROP TABLE IF EXISTS resource_events CASCADE;
DROP TABLE IF EXISTS user_events CASCADE;
DROP TABLE IF EXISTS requests CASCADE;
DROP TABLE IF EXISTS sessions CASCADE;
DROP TABLE IF EXISTS resources CASCADE;
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users (
  "id" SERIAL PRIMARY KEY,
  "username" TEXT NOT NULL UNIQUE,
  "password" TEXT NOT NULL
);

CREATE TABLE sessions (
  "id" SERIAL PRIMARY KEY,
  "access_token" TEXT NOT NULL UNIQUE,
  "user" INTEGER NOT NULL REFERENCES "users",
  "created_at" TIMESTAMP NOT NULL,
  "last_active" TIMESTAMP NOT NULL,
  "ttl" INTEGER NOT NULL
);

CREATE TABLE resources (
  "id" SERIAL PRIMARY KEY,
  "access_token" TEXT NOT NULL UNIQUE,
  "path" TEXT NOT NULL,
  "created_at" TIMESTAMP NOT NULL,
  "ttl" INTEGER NOT NULL,
  "max_unique_visitors" INTEGER NOT NULL,
  "creator" INTEGER NOT NULL REFERENCES "users"
);

CREATE TABLE requests (
  "id" SERIAL PRIMARY KEY,
  "timestamp" TIMESTAMP NOT NULL,
  "referer" TEXT,
  "ip" TEXT NOT NULL,
  "user_agent" TEXT
);

CREATE TABLE resource_events (
  "id" SERIAL PRIMARY KEY,
  "resource" INTEGER REFERENCES "resources",
  "request" INTEGER REFERENCES "requests",
  "type" SMALLINT NOT NULL
);

CREATE TABLE user_events (
  "id" SERIAL PRIMARY KEY,
  "user" INTEGER REFERENCES "users",
  "request" INTEGER REFERENCES "requests",
  "type" SMALLINT NOT NULL
);