-- Start create transactions --
-- Product info

-- BEGIN TRANSACTION;

-- SET TRANSACTION ISOLATION LEVEL READ COMMITTED READ ONLY;

-- SELECT prodName, prodDescription, prodImageID, price, stock, avg(rating) FROM Product
-- WHERE id=$id;

-- SELECT avg(rating) FROM Review
-- WHERE idProduct=$idProduct;

-- SELECT content, rating, reviewDate FROM Review
-- WHERE idProduct=$idProduct
-- ORDER BY rating desc
-- LIMIT 7;

-- COMMIT;
-- Product Info end

-- ALTER TABLE product ADD COLUMN tsvectors TSVECTOR;

-- CREATE FUNCTION productSearchUpdate() RETURNS TRIGGER AS $$
-- DECLARE newName text = (SELECT name from product where id = NEW.id);
-- DECLARE oldName text = (SELECT name from product where id = OLD.id);
-- BEGIN
--     IF TG_OP = ‘INSERT’ THEN
--         NEW.tsvectors = (
--             setweitght(to_tsvector(‘english’,New.title), ‘A’) ||                setweitght(to_tsvector(‘english’,newName), ‘B’)
--         );
--     END IF;

--     IF TG_OP = ‘UPDATE’ THEN
--         IF (NEW.name <> OLD.name OR newName <> oldName) THEN
--             setweitght(to_tsvector(‘english’,New.title), ‘A’) ||                setweitght(to_tsvector(‘english’,newName), ‘B’)
--         );
--         END IF;
--     END IF;
    
--     RETURN NEW;
-- END $$
-- LANGUAGE plpgsql;

-- CREATE TRIGGER productSearchUpdate
--     BEFORE INSERT OR UPDATE ON product
--     FOR EACH ROW
--     EXECUTE PROCEDURE productSearchUpdate();

-- CREATE INDEX product_search ON product UNSING GIST(tsvectors);

-- End create transactions --
*/