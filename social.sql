/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 80018
 Source Host           : localhost:3306
 Source Schema         : social

 Target Server Type    : MySQL
 Target Server Version : 80018
 File Encoding         : 65001

 Date: 11/03/2020 10:14:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_time` timestamp(0) NOT NULL,
  PRIMARY KEY (`comment_id`) USING BTREE,
  INDEX `post_id`(`post_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES (1, 12, 2, 'test', '2020-03-06 11:42:30');
INSERT INTO `comments` VALUES (2, 12, 2, 'test a', '2020-03-06 11:51:05');
INSERT INTO `comments` VALUES (3, 12, 2, 'test a', '2020-03-06 11:51:17');
INSERT INTO `comments` VALUES (4, 12, 4, 'test a', '2020-03-06 11:52:45');
INSERT INTO `comments` VALUES (5, 11, 4, 'test b', '2020-03-06 11:53:12');
INSERT INTO `comments` VALUES (6, 7, 4, 'ra đại học y đê :v', '2020-03-06 14:42:09');
INSERT INTO `comments` VALUES (7, 12, 4, 'test cmt', '2020-03-06 14:48:52');
INSERT INTO `comments` VALUES (8, 12, 4, 'real time', '2020-03-06 14:50:16');
INSERT INTO `comments` VALUES (9, 12, 4, 'cmt real time', '2020-03-06 14:50:28');
INSERT INTO `comments` VALUES (10, 12, 6, 'gâu gâu gâu', '2020-03-06 14:52:03');
INSERT INTO `comments` VALUES (11, 13, 2, ':)) m nghĩ đi đâu', '2020-03-06 14:55:59');
INSERT INTO `comments` VALUES (12, 13, 4, 'chó có bắn đột kích không ', '2020-03-06 14:57:43');
INSERT INTO `comments` VALUES (13, 13, 6, ':)) tự do 1 kênh 2 p39 ae ơi', '2020-03-06 15:00:08');
INSERT INTO `comments` VALUES (14, 13, 6, 'vào nhanh nhé', '2020-03-06 15:01:46');
INSERT INTO `comments` VALUES (15, 13, 2, 'có thấy m đâu', '2020-03-06 15:20:33');
INSERT INTO `comments` VALUES (16, 12, 2, 'test', '2020-03-07 08:51:15');
INSERT INTO `comments` VALUES (17, 19, 2, 'test', '2020-03-07 10:43:12');
INSERT INTO `comments` VALUES (18, 22, 4, 'đi ra nhà trường dắt chó đi dạo phát', '2020-03-07 11:45:35');
INSERT INTO `comments` VALUES (19, 22, 4, 'aa', '2020-03-07 11:51:02');
INSERT INTO `comments` VALUES (20, 21, 4, 'aaaaaaa', '2020-03-07 11:54:57');
INSERT INTO `comments` VALUES (21, 22, 1, 'abc', '2020-03-07 15:53:09');
INSERT INTO `comments` VALUES (22, 24, 2, 'hello test', '2020-03-07 17:01:00');
INSERT INTO `comments` VALUES (23, 29, 2, 'nice image :)', '2020-03-08 16:35:41');
INSERT INTO `comments` VALUES (24, 29, 4, 'nice image :)) carousel slide prefect', '2020-03-08 17:01:00');
INSERT INTO `comments` VALUES (25, 33, 2, 'ny ngon thế :))', '2020-03-08 17:17:28');
INSERT INTO `comments` VALUES (26, 34, 2, 'fix success', '2020-03-08 17:26:17');
INSERT INTO `comments` VALUES (27, 40, 2, 'test cmt', '2020-03-10 10:27:50');
INSERT INTO `comments` VALUES (28, 36, 2, 'abc', '2020-03-10 16:38:12');

-- ----------------------------
-- Table structure for follow
-- ----------------------------
DROP TABLE IF EXISTS `follow`;
CREATE TABLE `follow`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sender_id`(`sender_id`) USING BTREE,
  INDEX `receiver_id`(`receiver_id`) USING BTREE,
  CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of follow
-- ----------------------------
INSERT INTO `follow` VALUES (3, 5, 4);
INSERT INTO `follow` VALUES (18, 2, 4);
INSERT INTO `follow` VALUES (21, 4, 6);
INSERT INTO `follow` VALUES (22, 5, 6);
INSERT INTO `follow` VALUES (23, 2, 6);
INSERT INTO `follow` VALUES (24, 1, 6);
INSERT INTO `follow` VALUES (25, 6, 4);
INSERT INTO `follow` VALUES (26, 5, 1);
INSERT INTO `follow` VALUES (27, 4, 1);
INSERT INTO `follow` VALUES (28, 2, 1);
INSERT INTO `follow` VALUES (29, 6, 1);
INSERT INTO `follow` VALUES (32, 5, 2);
INSERT INTO `follow` VALUES (35, 6, 2);

-- ----------------------------
-- Table structure for likes
-- ----------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes`  (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`like_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of likes
-- ----------------------------
INSERT INTO `likes` VALUES (4, 2, 13);
INSERT INTO `likes` VALUES (8, 4, 13);
INSERT INTO `likes` VALUES (9, 4, 14);
INSERT INTO `likes` VALUES (10, 4, 18);
INSERT INTO `likes` VALUES (11, 4, 20);
INSERT INTO `likes` VALUES (12, 4, 21);
INSERT INTO `likes` VALUES (23, 4, 22);
INSERT INTO `likes` VALUES (29, 2, 20);
INSERT INTO `likes` VALUES (30, 2, 12);
INSERT INTO `likes` VALUES (31, 2, 11);
INSERT INTO `likes` VALUES (32, 1, 22);
INSERT INTO `likes` VALUES (33, 1, 21);
INSERT INTO `likes` VALUES (44, 2, 22);
INSERT INTO `likes` VALUES (45, 2, 24);
INSERT INTO `likes` VALUES (46, 2, 25);
INSERT INTO `likes` VALUES (47, 2, 29);
INSERT INTO `likes` VALUES (48, 4, 29);
INSERT INTO `likes` VALUES (49, 2, 33);
INSERT INTO `likes` VALUES (51, 2, 34);
INSERT INTO `likes` VALUES (52, 2, 32);
INSERT INTO `likes` VALUES (53, 2, 35);
INSERT INTO `likes` VALUES (54, 2, 36);
INSERT INTO `likes` VALUES (55, 2, 40);
INSERT INTO `likes` VALUES (56, 2, 39);
INSERT INTO `likes` VALUES (57, 2, 5);
INSERT INTO `likes` VALUES (58, 2, 1);
INSERT INTO `likes` VALUES (59, 2, 37);

-- ----------------------------
-- Table structure for notification
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification`  (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_receiver_id` int(11) NULL DEFAULT NULL,
  `notification_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `read_notification` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notification
-- ----------------------------
INSERT INTO `notification` VALUES (1, 4, '<p>mhieupham has share new post</p>', 'yes');
INSERT INTO `notification` VALUES (2, 6, '<p>mhieupham has share new post</p>', 'no');
INSERT INTO `notification` VALUES (3, 1, '<p>mhieupham has share new post</p>', 'no');
INSERT INTO `notification` VALUES (4, 6, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (5, 1, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (6, 2, '<p>hieu has share new post</p>', 'yes');
INSERT INTO `notification` VALUES (7, 6, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (8, 1, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (9, 2, '<p>hieu has share new post</p>', 'yes');
INSERT INTO `notification` VALUES (10, 6, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (11, 1, '<p>hieu has share new post</p>', 'no');
INSERT INTO `notification` VALUES (12, 2, '<p>hieu has share new post</p>', 'yes');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `post_datetime` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES (1, 2, 'hôm nay ngồi học', NULL, '2020-03-05 11:31:02');
INSERT INTO `posts` VALUES (2, 2, 'con cặc tao đau', NULL, '2020-03-05 12:08:56');
INSERT INTO `posts` VALUES (3, 2, 'Có người yêu có gì vui chứ . Chưa giúp gì được cho đất nước bày đặt yêu đương', NULL, '2020-03-05 12:10:49');
INSERT INTO `posts` VALUES (4, 2, 'Sáng học tập và làm việc theo đảng , trưa đi ăn cơm !!', NULL, '2020-03-05 12:14:24');
INSERT INTO `posts` VALUES (5, 2, 'ai chơi đột kích ko', NULL, '2020-03-05 12:16:53');
INSERT INTO `posts` VALUES (6, 4, 'hello everybody', NULL, '2020-03-05 14:13:46');
INSERT INTO `posts` VALUES (7, 5, ':)) chiều nay thể dục ở đâu giờ nhỉ\r\n', NULL, '2020-03-05 14:17:09');
INSERT INTO `posts` VALUES (8, 2, '5h ai lên đại học y đá cầu khôngggggggg', NULL, '2020-03-05 15:50:50');
INSERT INTO `posts` VALUES (9, 1, 'tao là bảng chữ cái', NULL, '2020-03-05 17:07:18');
INSERT INTO `posts` VALUES (10, 6, 'gâu gâu gâu', NULL, '2020-03-05 17:31:23');
INSERT INTO `posts` VALUES (11, 2, 'Story test', NULL, '2020-03-06 10:02:53');
INSERT INTO `posts` VALUES (12, 2, 'test 123', NULL, '2020-03-06 10:58:41');
INSERT INTO `posts` VALUES (13, 6, 'Chiều nay học xong đi đâu đây', NULL, '2020-03-06 14:54:19');
INSERT INTO `posts` VALUES (14, 2, 'abc', NULL, '2020-03-07 10:30:53');
INSERT INTO `posts` VALUES (15, 2, 'abcc', NULL, '2020-03-07 10:35:15');
INSERT INTO `posts` VALUES (16, 2, 'accc', NULL, '2020-03-07 10:37:17');
INSERT INTO `posts` VALUES (17, 2, 'Chiều nay học xong đi đâu đây', NULL, '2020-03-07 10:37:50');
INSERT INTO `posts` VALUES (18, 2, 'Chiều nay học xong đi đâu đây', NULL, '2020-03-07 10:41:40');
INSERT INTO `posts` VALUES (19, 2, 'gâu gâu gâu', NULL, '2020-03-07 10:41:48');
INSERT INTO `posts` VALUES (20, 4, 'gâu gâu gâu', NULL, '2020-03-07 10:57:07');
INSERT INTO `posts` VALUES (21, 4, 'Chiều nay học xong đi đâu đây', NULL, '2020-03-07 10:57:26');
INSERT INTO `posts` VALUES (22, 4, 'Chiều nay học xong đi đâu đây', NULL, '2020-03-07 10:58:19');
INSERT INTO `posts` VALUES (23, 2, 'tao là bảng chữ cái', NULL, '2020-03-07 17:00:35');
INSERT INTO `posts` VALUES (24, 2, 'hello everybody', NULL, '2020-03-07 17:00:45');
INSERT INTO `posts` VALUES (25, 2, 'a', NULL, '2020-03-08 14:22:53');
INSERT INTO `posts` VALUES (26, 2, 'a', NULL, '2020-03-08 14:25:08');
INSERT INTO `posts` VALUES (27, 2, 'test', NULL, '2020-03-08 16:14:44');
INSERT INTO `posts` VALUES (28, 2, 'a', NULL, '2020-03-08 16:19:35');
INSERT INTO `posts` VALUES (29, 2, 'test image', '[\"2123928097.jpg\",\"361587948.jpg\",\"1091028971.png\"]', '2020-03-08 16:21:47');
INSERT INTO `posts` VALUES (30, 4, 'tí nữa đi đâu đây nhỉ', NULL, '2020-03-08 17:09:24');
INSERT INTO `posts` VALUES (31, 4, 'tẹo nữa đi đâu nhỉ', NULL, '2020-03-08 17:13:15');
INSERT INTO `posts` VALUES (32, 4, 'đi chơi đê', NULL, '2020-03-08 17:15:52');
INSERT INTO `posts` VALUES (33, 4, ':)) mùng 8/3 cùng em người yêu', '[\"2143438388.jpg\"]', '2020-03-08 17:17:03');
INSERT INTO `posts` VALUES (34, 2, 'test', '[\"1990711497.jpg\",\"617655288.jpg\"]', '2020-03-08 17:22:23');
INSERT INTO `posts` VALUES (35, 2, 'text video', '[\"1773768223.mp4\"]', '2020-03-09 10:43:38');
INSERT INTO `posts` VALUES (36, 2, 'đi chơi', '[\"163366861.jpg\"]', '2020-03-09 11:02:59');
INSERT INTO `posts` VALUES (37, 2, 'test notification', NULL, '2020-03-09 14:58:55');
INSERT INTO `posts` VALUES (38, 4, 'test noti', NULL, '2020-03-09 15:31:28');
INSERT INTO `posts` VALUES (39, 4, 'test notification aaa', NULL, '2020-03-09 15:54:02');
INSERT INTO `posts` VALUES (40, 4, 'AAA', NULL, '2020-03-09 15:55:52');

-- ----------------------------
-- Table structure for repost
-- ----------------------------
DROP TABLE IF EXISTS `repost`;
CREATE TABLE `repost`  (
  `repost_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`repost_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of repost
-- ----------------------------
INSERT INTO `repost` VALUES (13, 13, 2);
INSERT INTO `repost` VALUES (14, 10, 2);
INSERT INTO `repost` VALUES (15, 19, 4);
INSERT INTO `repost` VALUES (16, 18, 4);
INSERT INTO `repost` VALUES (17, 13, 4);
INSERT INTO `repost` VALUES (18, 9, 2);
INSERT INTO `repost` VALUES (19, 6, 2);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_utf8mb4\\\'user-image.jpg\\\'',
  `bio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `follower_number` int(11) NULL DEFAULT '_utf8mb4\\\'0\\\'',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'hieu', '$2y$10$Xdq2XtzuMGfPvYcAIU4F/eUQVPTo7nskXcwWNy8cnbbsUhyv5Qewa', 'abc', 'user-image.jpg', NULL, 1);
INSERT INTO `users` VALUES (2, 'admin', '$2y$10$Xdq2XtzuMGfPvYcAIU4F/eUQVPTo7nskXcwWNy8cnbbsUhyv5Qewa', 'mhieupham', '381855756.jpg', 'đẹp trai à', 3);
INSERT INTO `users` VALUES (4, 'conbonghoi', '$2y$10$gpOfjJSMBJeWRZGC0byCoeb8EuXIzIMspgU.cw1cR3UuU2c5BXqNK', 'hieu', '1976699383.jpg', 'Loài bông', 2);
INSERT INTO `users` VALUES (5, 'mhieupham', '$2y$10$HFkkYj9hIQo0WqaSMtJJSuzMME3F/dw.3Pe1PyMtj5tM.HVsON9Yy', 'hieudeptrai1', '2005489428.jpg', '', 4);
INSERT INTO `users` VALUES (6, 'loaicho', '$2y$10$gI6KkDWpkhZIs6DQ0oyPa.EWcYDtzF2FwmdHG45csIZbmzXJfCfQ.', 'bông', 'user-image.jpg', NULL, 3);

SET FOREIGN_KEY_CHECKS = 1;
