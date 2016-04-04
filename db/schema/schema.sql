DROP TABLE IF EXISTS resource_event;
DROP TABLE IF EXISTS user_event;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS resources;
DROP TABLE IF EXISTS users;

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

CREATE TABLE resource_event (
	"id" SERIAL PRIMARY KEY,
	"resource" INTEGER REFERENCES "resources",
	"timestamp" TIMESTAMP NOT NULL,	
	"ip" TEXT NOT NULL,
	"type" SMALLINT NOT NULL
);

CREATE TABLE user_event (
  "id" SERIAL PRIMARY KEY,
  "user" INTEGER REFERENCES "users",
  "timestamp" TIMESTAMP NOT NULL, 
  "ip" TEXT NOT NULL,
  "type" SMALLINT NOT NULL
);