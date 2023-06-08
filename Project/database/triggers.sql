-- TRIGGER 01 (Update product score with the new Review added) --
CREATE FUNCTION updateProductRating() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE Product
    SET rating = (AVG(score) FROM Review WHERE Review.idProduct == New.id)
    WHERE Product.id = New.id;
    RETURN NULL;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER updateProductRating
    AFTER INSERT OR UPDATE ON Review
    FOR EACH ROW
EXECUTE PROCEDURE updateProductRating();

-- TRIGGER 02 (Clear the shop cart after the order was made) --
CREATE FUNCTION clearShopCart() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM ShopCart
    where userID = New.userID
    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER clearShopCart AFTER INSERT
ON Order
EXECUTE PROCEDURE clearShopCart();

-- TRIGGER 03 (A user can only review products that he bought) --
CREATE FUNCTION addReview() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (SELECT * FROM Order WHERE Order.idUser = New.idUser AND Order.idProduct = New.idProduct) THEN
        RAISE EXCEPTION 'You can only review products that you bought';
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addReview BEFORE INSERT OR UPDATE
ON Review
FOR EACH ROW
EXECUTE PROCEDURE addReview();

-- TRIGGER 04 (When a product is bough its stock is reduced) --
CREATE FUNCTION updateProductStock() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE Product
    SET stock = Product.stock - New.quantity
    WHERE Product.id = New.id;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER updateProductStock AFTER INSERT
ON Order
EXECUTE PROCEDURE updateProductStock();

-- TRIGGER 05 (A user can't buy more than the available quantity) --
CREATE FUNCTION checkOrderQuantity() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS
        (SELECT * FROM Product WHERE Product.id = New.id AND Product.stock >= New.quantity) 
    THEN
        RAISE EXCEPTION "You can't buy % items of product %", New.quantity, New.name;
    END IF;
    RETURN New;
END

CREATE TRIGGER checkProductQuantity BEFORE INSERT
ON Order
FOR EACH ROW
EXECUTE PROCEDURE checkOrderQuantity();







-- -- TRIGGER 01 (Insert review on the product) --
-- CREATE FUNCTION updateProductComments() RETURNS TRIGGER AS
-- $BODY$
-- BEGIN
--     IF NOT EXISTS (SELECT Product.productID FROM Review
--                     WHERE id = New.productID)
-- END
-- $BODY$
-- LANGUAGE plpgsql;

-- CREATE TRIGGER productComments AFTER INSERT OR UPDATE OR DELETE ON Review
-- EXECUTE PROCEDURE updateProductComments();



-- -- TRIGGER 03 (Update the stock depending on the products that are on the cirrent shop cart) --
-- CREATE FUNCTION updateProductStock() RETURNS TRIGGER AS
-- $BODY$
-- BEGIN
--     IF 
--         NOT EXISTS (SELECT stock FROM Product WHERE id = New.idProduct AND stock >= New.quantity)
--     THEN
--         RAISE EXCEPTION "You can't buy % items of product %", New.quantity, New.idProduct
-- END
-- $BODY$
-- LANGUAGE plpgsql

-- CREATE TRIGGER checkProductStock BEFORE INSERT
-- ON ShopCart
-- FOR EACH ROW
-- EXECUTE PROCEDURE updateProductStock();



-- -- TRIGGER 04 (Update product score with the newly added score) --
-- CREATE FUNCTION UpdateNumProductScore() RETURNS TRIGGER AS
-- $BODY$
-- BEGIN
--     UPDATE Product
--     SET rating = (AVG(score) FROM Review WHERE id = NEW.productID)
-- END
-- $BODY$
-- LANGUAGE plpgsql;

-- CREATE TRIGGER productScore AFTER INSERT
-- ON Review
-- EXECUTE PROCEDURE UpdateNumProductScore();



-- -- TRIGGER 05 (Clear the shop cart after the order was made) --
-- CREATE FUNCTION clearShopCart() RETURNS TRIGGER AS
-- $BODY$
-- BEGIN
--     DELETE FROM ShopCart
--     where userID = New.userID
-- END
-- $BODY$
-- LANGUAGE plpgsql;

-- CREATE TRIGGER clearCart AFTER INSERT
-- ON Order
-- EXECUTE PROCEDURE clearShopCart();



-- -- TRIGGER 06 (Update available products) --
-- CREATE FUNCTION updateAvailableProducts() RETURNS TRIGGER AS
-- $BODY$
-- BEGIN
--     UPDATE Product
--     SET stock = stock - New.quantity
--     WHERE id = New.productID
-- END
-- $BODY$

-- CREATE TRIGGER updateProductsStock AFTER INSERT
-- ON Order
-- EXECUTE PROCEDURE updateAvailableProducts();




