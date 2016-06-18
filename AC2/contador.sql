CREATE OR REPLACE FUNCTION
contador ()
RETURNS integer AS $$
DECLARE
tupla RECORD;
numero integer;
BEGIN
RETURN (SELECT count(*) as numero from Personas);
END
$$ language plpgsql