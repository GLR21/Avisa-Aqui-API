-- Create the avisaAquiAPI database if it doesn't exist
SELECT 'CREATE DATABASE avisaAquiAPI'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'avisaAquiAPI')\gexec

-- Create the avisaAquiAPI role as a superuser if it doesn't exist
DO
$do$
BEGIN
   IF NOT EXISTS (
      SELECT FROM pg_catalog.pg_roles
      WHERE rolname = 'avisaAquiAPI') THEN
      CREATE ROLE avisaAquiAPI WITH LOGIN SUPERUSER PASSWORD 'avisaAquiAPI';
   END IF;
END
$do$;

-- Grant all privileges on the avisaAquiAPI database to the avisaAquiAPI role
GRANT ALL PRIVILEGES ON DATABASE avisaAquiAPI TO avisaAquiAPI;
