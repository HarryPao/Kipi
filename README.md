# Kipi

Kipi is a Instagram-like social media enables users to share their daily lives and interact with their friends and family.
It contains basic functions listed below:

1. Login, logout, sign up, edit personal profile.
2. Post/upload image and write something to user's own personal page.
3. Comments on any post below the post image.
4. Edit or delete any posts and comments that belongs to user him/herself.

--------------------------------------------------------------------------------
# Database of Kipi

Kipi use MySQL as Kipi's database, and it contains 3 table which are 'user', 'post', 'comments'.
'user' table contains 12 keys:
1. id               (int)
2. account          (varchar)
3. pwd              (varchar)
4. email            (varchar)
5. nickname         (varchar)
6. birthday         (date)
7. gender           (int)
8. job              (varchar)
9. education        (varchar)
10. intro           (varchar)
11. profile_img     (mediumblob)
12. authority       (int)

'post' table contains 6 keys:
1. id               (int)
2. content          (varchar)
3. photo            (longblob)
4. likes            (int)
5. comments         (int)
6. user_account     (varchar)

'comments' table contains 7 keys:
1. id               (int)
2. likes            (int)
3. comment          (varchar)
4. post_id          (int)
5. comment_account  (varchar)
6. time             (datetime)
7. ip               (varchar)

--------------------------------------------------------------------------------
# Security of Kipi

Kipi use some basic measures to protect users' privacy and ensure network security:
When login, the program use 'preg_replace()' to prevent SQL injection.
Kipi use '$_SESSION('account')' to check the identity of user and authorities of editing/deleting/posting lest illegal access.
Kipi also avoid attack by using 'htmlspecialchars()'.
Nevertheless, Kipi is currently unable to prevent attack from uploading files.
