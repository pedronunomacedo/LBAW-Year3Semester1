-- Start create indexes --
CREATE INDEX usersUsername ON users USING hash (name); -- user name
-- 1) CREATE INDEX userAddresses ON Address USING hash (id); -- userID
-- 2) CREATE INDEX userPurchases ON Order USING hash (id); -- userID
CREATE INDEX productReviews ON Review USING hash (id); -- productID
CREATE INDEX productsCategory ON Product USING hash (id); -- categoryID
CREATE INDEX searchProducts ON Product USING hash (prodName); -- Product name
CREATE INDEX orderProductsDESC ON Product USING btree(price);

-- End create indexes --