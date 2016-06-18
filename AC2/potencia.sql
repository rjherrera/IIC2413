CREATE OR REPLACE FUNCTION
potencia (iesima integer)
RETURNS float AS $$
BEGIN
RETURN pow(2, iesima);
END
$$ language plpgsql