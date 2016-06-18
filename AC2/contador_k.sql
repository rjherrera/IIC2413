CREATE OR REPLACE FUNCTION
contador_k ()
RETURNS integer AS $$
DECLARE
tupla RECORD;
numero integer;
BEGIN
RETURN (SELECT count(ks.run) from (select * from Personas where run LIKE '%-k') as ks);
END
$$ language plpgsql