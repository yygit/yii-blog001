/*
PGSQL Backup
Source Server Version: 9.1.6
Source Database: softlogic
Date: 03.03.2013 22:46:11
*/


-- ----------------------------
--  Table structure for "public"."tbl_comment"
-- ----------------------------
DROP TABLE IF EXISTS  "public"."tbl_comment";
CREATE TABLE "public"."tbl_comment" (
"id" int4 NOT NULL,
"content" text NOT NULL,
"status" int4 NOT NULL,
"create_time" int4 NOT NULL,
"author" varchar(128) NOT NULL,
"email" varchar(128) NOT NULL,
"url" varchar(128) DEFAULT NULL::character varying,
"post_id" int4 NOT NULL,
PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;;

-- ----------------------------
--  Table structure for "public"."tbl_lookup"
-- ----------------------------
DROP TABLE IF EXISTS  "public"."tbl_lookup";
CREATE TABLE "public"."tbl_lookup" (
"id" int4 NOT NULL,
"name" varchar(128) NOT NULL,
"code" int4 NOT NULL,
"type" varchar(128) NOT NULL,
"position" int4 NOT NULL,
PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;;

-- ----------------------------
--  Table structure for "public"."tbl_post"
-- ----------------------------
DROP TABLE IF EXISTS  "public"."tbl_post";
CREATE TABLE "public"."tbl_post" (
"id" int4 NOT NULL,
"title" varchar(128) NOT NULL,
"content" text NOT NULL,
"tags" text NOT NULL,
"status" int4 NOT NULL,
"create_time" int4,
"update_time" int4,
"author_id" int4 NOT NULL,
PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;;

-- ----------------------------
--  Table structure for "public"."tbl_tag"
-- ----------------------------
DROP TABLE IF EXISTS  "public"."tbl_tag";
CREATE TABLE "public"."tbl_tag" (
"id" int4 NOT NULL,
"name" varchar(128) NOT NULL,
"frequency" int4 DEFAULT 1 NOT NULL,
PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;;

-- ----------------------------
--  Table structure for "public"."tbl_user"
-- ----------------------------
DROP TABLE IF EXISTS  "public"."tbl_user";
CREATE TABLE "public"."tbl_user" (
"id" int4 NOT NULL,
"username" varchar(128) NOT NULL,
"password" varchar(128) NOT NULL,
"salt" varchar(128) NOT NULL,
"email" varchar(128) NOT NULL,
"profile" text,
PRIMARY KEY ("id")
)
WITH (OIDS=FALSE)
;;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO "public"."tbl_comment" VALUES ('1','This is a test comment.','2','1230952187','Tester','tester@example.com',NULL,'2');
INSERT INTO "public"."tbl_lookup" VALUES ('1','Draft','1','PostStatus','1'); INSERT INTO "public"."tbl_lookup" VALUES ('2','Published','2','PostStatus','2'); INSERT INTO "public"."tbl_lookup" VALUES ('3','Archived','3','PostStatus','3'); INSERT INTO "public"."tbl_lookup" VALUES ('4','Pending Approval','1','CommentStatus','1'); INSERT INTO "public"."tbl_lookup" VALUES ('5','Approved','2','CommentStatus','2');
INSERT INTO "public"."tbl_post" VALUES ('1','Welcome!','This blog system is developed using Yii. It is meant to demonstrate how to use Yii to build a complete real-world application. Complete source code may be found in the Yii releases.\n\nFeel free to try this system by writing new posts and posting comments.','yii, blog','2','1230952187','1230952187','1'); INSERT INTO "public"."tbl_post" VALUES ('2','A Test Post','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','test','2','1230952187','1230952187','1');
INSERT INTO "public"."tbl_tag" VALUES ('1','yii','1'); INSERT INTO "public"."tbl_tag" VALUES ('2','blog','1'); INSERT INTO "public"."tbl_tag" VALUES ('3','test','1');
INSERT INTO "public"."tbl_user" VALUES ('1','demo','2e5c7db760a33498023813489cfadc0b','28b206548469ce62182048fd9cf91760','webmaster@example.com',NULL); INSERT INTO "public"."tbl_user" VALUES ('2','user1','2e5c7db760a33498023813489cfadc0b','28b206548469ce62182048fd9cf91760','webmaster@example.com',NULL); INSERT INTO "public"."tbl_user" VALUES ('3','user2','2e5c7db760a33498023813489cfadc0b','28b206548469ce62182048fd9cf91760','webmaster@example.com',NULL);

-- ----------------------------
--  Index definition for "public"."tbl_comment"
-- ----------------------------
CREATE INDEX "FK_comment_post" ON "public"."tbl_comment" USING btree ("post_id");


-- ----------------------------
--  Index definition for "public"."tbl_post"
-- ----------------------------
CREATE INDEX "FK_post_author" ON "public"."tbl_post" USING btree ("author_id");


ALTER TABLE "public"."tbl_comment" ADD CONSTRAINT "FK_comment_post" FOREIGN KEY ("post_id") REFERENCES "public"."tbl_post" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE "public"."tbl_post" ADD CONSTRAINT "FK_post_author" FOREIGN KEY ("author_id") REFERENCES "public"."tbl_user" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;