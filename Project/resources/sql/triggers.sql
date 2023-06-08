-- Start create triggers --
-- DROP TRIGGER IF EXISTS updateProductRating ON Review CASCADE;
-- -- TRIGGER 01 (Update product score with the new Review added)
-- CREATE OR REPLACE FUNCTION logUpdateProductRating() RETURNS TRIGGER AS 
-- $BODY$
-- BEGIN
--    -- trigger logic
--    IF TG_OP = 'INSERT' THEN
--      UPDATE Product
--      SET score = ROUND((SELECT AVG(rating) FROM Review WHERE New.idProduct = Product.id),1)
--      WHERE Product.id = NEW.idProduct;
--    END IF;
--    --RETURN coalesce(NEW, OLD);
--    RETURN New;
-- END
-- $BODY$
-- LANGUAGE plpgsql;

-- CREATE TRIGGER updateProductRating
--   AFTER INSERT OR UPDATE
--   ON Review
--   FOR EACH ROW
--   EXECUTE PROCEDURE logUpdateProductRating();


/*
DROP FUNCTION IF EXISTS logDeleteProductFromShopCart CASCADE;
DROP TRIGGER IF EXISTS deleteProductFromShopCart ON Review CASCADE;
-- TRIGGER 02 (delete a product from the shop cart)
CREATE OR REPLACE FUNCTION logDeleteProductFromShopCart() RETURNS TRIGGER AS 
$BODY$
BEGIN
   -- trigger logic
   IF TG_OP = 'INSERT' THEN
       DELETE FROM ShopCart
       where (ShopCart.idusers = (SELECT idusers FROM Orders WHERE Orders.id = NEW.idOrders)) AND (idProduct = NEW.idProduct);
   END IF;
   
   RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER deleteProductFromShopCart
  AFTER INSERT OR UPDATE
  ON ProductOrder
  FOR EACH ROW
  EXECUTE PROCEDURE logDeleteProductFromShopCart();


DROP FUNCTION IF EXISTS logAddReview CASCADE;
DROP TRIGGER IF EXISTS addReview ON Review CASCADE;
-- TRIGGER 03 (A user can only review products that he bought)
CREATE FUNCTION logAddReview() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (SELECT ProductOrder.idProduct from (SELECT Orders.id as orderID FROM Orders WHERE Orders.idusers = NEW.idusers) as UserOrders, ProductOrder WHERE UserOrders.orderID = ProductOrder.idOrders AND ProductOrder.idProduct = NEW.idProduct) THEN 
        RAISE EXCEPTION 'User can only review products he had bought (%,%)!', NEW.idusers, NEW.idProduct;
    END IF;
    RETURN New;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER addReview BEFORE INSERT
ON Review
FOR EACH ROW
EXECUTE PROCEDURE logAddReview();


DROP FUNCTION IF EXISTS logUpdateProductStock CASCADE;
DROP TRIGGER IF EXISTS updateProductStock ON Review CASCADE;
-- TRIGGER 04 (When a product is bough its stock is reduced)
CREATE FUNCTION logUpdateProductStock() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE Product
    SET stock = Product.stock - New.quantity
    WHERE Product.id = New.idProduct;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER updateProductStock AFTER INSERT
ON ProductOrder
FOR EACH ROW
EXECUTE PROCEDURE logUpdateProductStock();

DROP FUNCTION IF EXISTS logVerifyProductStock CASCADE;
DROP TRIGGER IF EXISTS verifyProductStock ON Review CASCADE;
-- TRIGGER 05 (A user can't buy more than the available quantity)
CREATE FUNCTION logVerifyProductStock() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (((SELECT stock FROM Product WHERE id = NEW.idProduct) - NEW.quantity) < 0) THEN
        RAISE EXCEPTION 'There is not enough stock of this product!';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verifyProductStock BEFORE INSERT
ON ProductOrder
FOR EACH ROW
EXECUTE PROCEDURE logVerifyProductStock();

-- End create triggers --