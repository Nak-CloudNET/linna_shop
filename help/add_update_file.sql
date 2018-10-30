/* 05/04/2018 By Kaoly */
ALTER TABLE `erp_pos_register`
ADD COLUMN `cash_in`  text NULL AFTER `closed_by`,
ADD COLUMN `cash_out`  text NULL AFTER `cash_in`;

/* 25/04/2018 By Kaoly */
ALTER TABLE `erp_return_items`
ADD COLUMN `expiry`  date NULL AFTER `wpiece`,
ADD COLUMN `expiry_id`  int(11) NULL AFTER `expiry`;

/* 07/05/2018 By Chanthy */
ALTER TABLE `erp_customer_groups`
ADD COLUMN `order_discount`  int(11) NULL AFTER `makeup_cost`;

/* 16/08/2018 By Nak */
ALTER TABLE `erp_gl_charts`
ADD COLUMN `inventory`  tinyint(1) NULL AFTER `bank`;

/* 21/08/2018 By Nak */
ALTER TABLE `erp_suspended_items`
ADD COLUMN `quantity_balance`  decimal(15,4) NULL AFTER `quantity`;

/* 30/08/2018 By Nak */
ALTER TABLE `erp_stock_trans`
ADD COLUMN `last_qty`  decimal(28,8) NULL AFTER `serial`;

/* 14/09/2018 By Nak */
ALTER TABLE `erp_payment_term`
ADD COLUMN `description_kh`  varchar(255) NULL AFTER `description`;

/* Unknown */
ALTER TABLE `erp_purchase_items`
ADD COLUMN `biller_id`  int(11) NULL AFTER `product_id`;



