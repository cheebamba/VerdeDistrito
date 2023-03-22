CREATE TABLE vd_config (
  config_cat varchar(24) NOT NULL default '',
  config_name varchar(32) NOT NULL default '',
  config_value text NOT NULL,
  config_default varchar(255) NOT NULL default '',
  config_text varchar(255) NOT NULL default '',
  config_id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (config_id)
) TYPE=MyISAM;

INSERT INTO vd_config VALUES ('global', 'maintitle', 'Verde Distrito', 'qSystem', 'Nazwa strony', 1);
INSERT INTO vd_config VALUES ('global', 'subtitle', 'Multigaming Clan ', 'gaming CMS', 'Opis strony', 2);
INSERT INTO vd_config VALUES ('images', 'avatarmaxx', '100', '', 'Maxymalna szerokosc avatara', 3);
INSERT INTO vd_config VALUES ('images', 'avatarmaxs', '30720', '', 'Maxymalna wielkosc avatara(w bajtach)', 4);
INSERT INTO vd_config VALUES ('images', 'photomaxs', '261440', '', 'Maxymalna wielkosc zdjecia (w bajtach)', 5);
INSERT INTO vd_config VALUES ('images', 'photomaxy', '200', '', 'Maxymalna wysokosc zdjecia', 6);
INSERT INTO vd_config VALUES ('images', 'photomaxx', '300', '', 'Maxymalna szerokosc zdjecia', 7);
INSERT INTO vd_config VALUES ('global', 'mainurl', 'http://www.sciema.czuby.net/VerdeDistrito/', '', 'Adres URL strony', 8);
INSERT INTO vd_config VALUES ('global', 'admail', 'qalix@op.pl', '', 'Mail admina', 10);
INSERT INTO vd_config VALUES ('global', 'domain', 'www.VerdeDistrito.pl', '', 'Domena strony', 11);
INSERT INTO vd_config VALUES ('users', 'maxperpage', '50', '', 'Ilosc uzytkownikow na jedna stronie', 12);
INSERT INTO vd_config VALUES ('news', 'maxindex', '10', '', 'Ilosc newsow na stronie glownej', 13);
INSERT INTO vd_config VALUES ('comments', 'perpage', '30', '', 'Ilosc komentarzy na jednej stronie', 14);

CREATE TABLE vd_users (
  user_id int(11) NOT NULL auto_increment,
  user_active tinyint(1) unsigned NOT NULL default '0',
  user_member tinyint(1) unsigned NOT NULL default '0',
  user_nick varchar(24) NOT NULL default '',
  user_password varchar(32) NOT NULL default '',
  user_name varchar(24) NOT NULL default '',
  user_surname varchar(24) NOT NULL default '',
  user_level tinyint(2) unsigned NOT NULL default '1',
  user_country char(2) NOT NULL default '',
  user_text text NOT NULL,
  user_avatar varchar(255) NOT NULL default '',
  user_photo varchar(255) NOT NULL default '',
  user_signature varchar(255) NOT NULL default '',
  user_hardcpu varchar(32) default NULL,
  user_hardmb varchar(32) default NULL,
  user_hardram varchar(32) default NULL,
  user_hardstor varchar(32) default NULL,
  user_hardgc varchar(32) default NULL,
  user_hardmc varchar(32) default NULL,
  user_hardmon varchar(32) default NULL,
  user_hardmouse varchar(32) default NULL,
  user_hardpad varchar(32) default NULL,
  user_hardhp varchar(32) default NULL,
  user_hardnet varchar(32) default NULL,
  user_hardos varchar(32) default NULL,
  user_hardres varchar(32) default NULL,
  user_hardsens varchar(32) default NULL,
  user_favdrink varchar(32) default NULL,
  user_favfood varchar(32) default NULL,
  user_favbook varchar(32) default NULL,
  user_favmov varchar(32) default NULL,
  user_favact varchar(32) default NULL,
  user_favmus varchar(32) default NULL,
  user_favhobby varchar(32) default NULL,
  user_favplr varchar(32) default NULL,
  user_favourplr varchar(32) default NULL,
  user_favteam varchar(32) default NULL,
  user_favsport varchar(32) default NULL,
  user_favgame varchar(32) default NULL,
  user_occupation varchar(64) NOT NULL default '',
  user_origin char(2) NOT NULL default 'pl',
  user_location varchar(64) NOT NULL default '',
  user_timezone decimal(2,0) NOT NULL default '0',
  user_birthdate date NOT NULL default '0000-00-00',
  user_gender char(1) NOT NULL default '0',
  user_gg varchar(16) NOT NULL default '',
  user_irc varchar(128) NOT NULL default '',
  user_msn varchar(64) NOT NULL default '',
  user_icq varchar(16) NOT NULL default '',
  user_website varchar(128) NOT NULL default '',
  user_email varchar(64) NOT NULL default '',
  user_skin varchar(16) NOT NULL default '',
  user_lang varchar(16) NOT NULL default '',
  user_regdate datetime NOT NULL default '0000-00-00 00:00:00',
  user_lastlog datetime NOT NULL default '0000-00-00 00:00:00',
  user_lastvisit datetime NOT NULL default '0000-00-00 00:00:00',
  user_lastvisitf1 datetime NOT NULL default '0000-00-00 00:00:00',
  user_lastvisitf2 datetime NOT NULL default '0000-00-00 00:00:00',
  user_lastsesid VARCHAR(64) NOT NULL default '',
  user_lastip varchar(16) NOT NULL default '',
  user_logcount int(11) unsigned NOT NULL default '0',
  user_postcount int(11) default '0',
  user_topiccount int(11) default '0',
  user_code VARCHAR(255) NOT NULL default '',
  PRIMARY KEY  (user_id)
) TYPE=MyISAM;

CREATE TABLE vd_log (
  log_id mediumint(11) NOT NULL auto_increment,
  log_date datetime NOT NULL default '0000-00-00 00:00:00',
  log_ip varchar(16) NOT NULL default '',
  log_nick varchar(24) NOT NULL default '',
  log_userid int(11) NOT NULL default '0',
  log_text varchar(255) NOT NULL default '',
  PRIMARY KEY  (log_id)
) TYPE=MyISAM;

CREATE TABLE vd_levels (
  level_level tinyint(2) unsigned NOT NULL default '0',
  level_name varchar(32) NOT NULL default '',
  level_acs_authorizer tinyint(1) default '0',
  level_acs_news tinyint(1) default '0',
  level_acs_cats tinyint(1) default '0',
  level_acs_levels tinyint(1) default '0',
  level_acs_articles tinyint(1) default '0',
  level_acs_wars tinyint(1) default '0',
  level_acs_gallery tinyint(1) default '0',
  level_acs_emots tinyint(1) default '0',
  level_acs_team tinyint(1) default '0',
  level_acs_download tinyint(1) default '0',
  level_acs_comments tinyint(1) default '0',
  level_acs_logs tinyint(1) default '0',
  level_acs_forums tinyint(1) default '0',
  level_acs_polls tinyint(1) default '0',
  level_acs_pages tinyint(1) default '0',
  level_acs_upload tinyint(1) default '0',
  level_acs_users tinyint(1) default '0',
  level_acs_config tinyint(1) default '0',
  level_acs_panel tinyint(1) default '0',
  level_acs_tools tinyint(1) default '0'
) TYPE=MyISAM;

INSERT INTO vd_levels VALUES (20, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO vd_levels VALUES (1, 'U¿ytkownik', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO vd_levels VALUES (10, 'Redaktor', 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0);
INSERT INTO vd_levels VALUES (4, 'Cz³onek', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

CREATE TABLE vd_pms (
  pm_id int(11) unsigned NOT NULL auto_increment,
  pm_date datetime NOT NULL default '0000-00-00 00:00:00',
  pm_fromuser int(11) NOT NULL default '0',
  pm_touser int(11) NOT NULL default '0',
  pm_status tinyint(1) unsigned NOT NULL default '0',
  pm_fromstatus tinyint(1) unsigned NOT NULL default '0',
  pm_title varchar(64) NOT NULL default '0',
  pm_text text NOT NULL,
  PRIMARY KEY  (pm_id)
) TYPE=MyISAM;

CREATE TABLE vd_news (
  news_id mediumint(8) unsigned NOT NULL auto_increment,
  news_minlevel int(11) NOT NULL default '0',
  news_title varchar(64) NOT NULL default '',
  news_text text NOT NULL,
  news_text2 text NOT NULL,
  news_cat varchar(16) NOT NULL default '',
  news_status tinyint(1) unsigned NOT NULL default '0',
  news_ownerid mediumint(8) NOT NULL default '0',
  news_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (news_id)
) TYPE=MyISAM;

CREATE TABLE vd_comments (
  comment_id mediumint(8) unsigned NOT NULL auto_increment,
  comment_text text NOT NULL,
  comment_cat varchar(16) NOT NULL default '',
  comment_pageid mediumint(8) NOT NULL default '0',
  comment_ownerid mediumint(8) NOT NULL default '0',
  comment_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (comment_id)
) TYPE=MyISAM;

CREATE TABLE vd_articles (
  article_id mediumint(8) NOT NULL default '0',
  article_page mediumint(8) NOT NULL default '0',
  article_title varchar(64) NOT NULL default '',
  article_text text NOT NULL,
  article_cat varchar(16) NOT NULL default 'vd',
  article_avatar varchar(255) NOT NULL default '',
  article_status tinyint(1) unsigned NOT NULL default '0',
  article_ownerid mediumint(8) NOT NULL default '0',
  article_date datetime NOT NULL default '0000-00-00 00:00:00'
) TYPE=MyISAM;

CREATE TABLE vd_cats (
  cat_id mediumint(8) NOT NULL default '0',
  cat_subid mediumint(8) NOT NULL default '0',
  cat_title varchar(64) NOT NULL default '',
  cat_st varchar(64) NOT NULL default '',
  cat_ico text NOT NULL,
  cat_minlevel int(11) NOT NULL default '0',
  PRIMARY KEY  (cat_aid)
) TYPE=MyISAM;

INSERT INTO vd_cats VALUES (1, 1, 'News', 'news', '', 0);
INSERT INTO vd_cats VALUES (1, 2, 'Glowna', 'mn', 'none.gif', 0);
INSERT INTO vd_cats VALUES (2, 1, 'Articles', 'art', '', 0);
INSERT INTO vd_cats VALUES (2, 2, 'VD', 'mn', 'none.gif', 0);
INSERT INTO vd_cats VALUES (3, 1, 'Team', 'team', '', 0);
INSERT INTO vd_cats VALUES (3, 2, 'Redakcja', 'mn', 'none.gif', 0);
INSERT INTO vd_cats VALUES (4, 1, 'Ligi', 'leev', '', 0);
INSERT INTO vd_cats VALUES (4, 2, '1 Liga', 'mn', 'none.gif', 0);
INSERT INTO vd_cats VALUES (5, 1, 'Gry', 'games', '', 0);
INSERT INTO vd_cats VALUES (5, 2, '1 Gra', 'mn', 'none.gif', 0);
INSERT INTO vd_cats VALUES (6, 1, 'Pliki', 'files', '', 0);
INSERT INTO vd_cats VALUES (6, 2, 'Pliki 1', 'mn', 'none.gif', 0);

CREATE TABLE vd_smiles (
  smile_id int(11) NOT NULL auto_increment,
  smile_code varchar(16) NOT NULL default '',
  smile_image varchar(128) NOT NULL default '',
  smile_text varchar(32) NOT NULL default '',
  PRIMARY KEY  (smile_id)
) TYPE=MyISAM;

CREATE TABLE vd_online (
  online_id int(11) NOT NULL auto_increment,
  online_userid mediumint(8) NOT NULL default '0',
  online_where varchar(64) NOT NULL default '',
  online_ip varchar(16) NOT NULL default '',
  online_lastvisit varchar(32) NOT NULL default '',
  PRIMARY KEY  (online_id)
) TYPE=MyISAM;

CREATE TABLE vd_shoutbox (
  shout_id mediumint(8) unsigned NOT NULL auto_increment,
  shout_text text NOT NULL,
  shout_ownerid mediumint(8) NOT NULL default '0',
  shout_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (shout_id)
) TYPE=MyISAM;

CREATE TABLE vd_friends (
  friend_id mediumint(8) unsigned NOT NULL auto_increment,
  friend_1 mediumint(8) NOT NULL default '0',
  friend_2 mediumint(8) NOT NULL default '0',
  friend_status tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (friend_id)
) TYPE=MyISAM;

CREATE TABLE vd_pages (
  page_id mediumint(8) unsigned NOT NULL auto_increment,
  page_minlevel int(11) NOT NULL default '0',
  page_title varchar(64) NOT NULL default '',
  page_text text NOT NULL,
  page_ownerid mediumint(8) NOT NULL default '0',
  page_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (page_id)
) TYPE=MyISAM;

CREATE TABLE vd_members (
  member_id mediumint(8) unsigned NOT NULL auto_increment,
  member_subid mediumint(8) NOT NULL default '0',
  member_div varchar(64) NOT NULL default '',
  member_text text NOT NULL,
  member_leader int(11) NOT NULL default '0',
  member_inactive int(11) NOT NULL default '0',
  member_userid mediumint(8) NOT NULL default '0',
  member_photo varchar(255) NOT NULL default '',
  PRIMARY KEY  (member_id)
) TYPE=MyISAM;

CREATE TABLE vd_divs (
  div_id mediumint(8) unsigned NOT NULL auto_increment,
  div_subid mediumint(8) NOT NULL default '0',
  div_name varchar(64) NOT NULL default '',
  div_st varchar(64) NOT NULL default '',
  PRIMARY KEY  (div_id)
) TYPE=MyISAM;

CREATE TABLE vd_wars (
  war_id mediumint(8) unsigned NOT NULL auto_increment,
  war_div varchar(64) NOT NULL default '',
  war_date datetime NOT NULL default '0000-00-00 00:00:00',
  war_map1 varchar(64) NOT NULL default '',
  war_map2 varchar(64) NOT NULL default '',
  war_tv varchar(64) NOT NULL default '',
  war_sb varchar(64) NOT NULL default '',
  war_lcountry char(2) NOT NULL default '',
  war_lst varchar(32) NOT NULL default '',
  war_ltitle varchar(64) NOT NULL default '',
  war_opp varchar(32) NOT NULL default '',
  war_ucountry char(2) NOT NULL default '',
  war_ocountry char(2) NOT NULL default '',
  war_ur mediumint(8) NOT NULL default '0',
  war_or mediumint(8) NOT NULL default '0',
  war_us varchar(255) NOT NULL default '',
  war_os varchar(255) NOT NULL default '',
  war_avatar varchar(255) NOT NULL default '',
  war_text text NOT NULL,
  PRIMARY KEY  (war_id)
) TYPE=MyISAM;

CREATE TABLE vd_files (
  file_id mediumint(8) unsigned NOT NULL auto_increment,
  file_minlevel int(11) NOT NULL default '0',
  file_title varchar(64) NOT NULL default '',
  file_text text NOT NULL,
  file_url text NOT NULL,
  file_size varchar(64) NOT NULL default '0',
  file_down int(64) NOT NULL default '0',
  file_cat varchar(16) NOT NULL default '',
  file_ownerid mediumint(8) NOT NULL default '0',
  file_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (file_id)
) TYPE=MyISAM;

CREATE TABLE vd_fcats (
  cat_id mediumint(8) unsigned NOT NULL auto_increment,
  cat_subid mediumint(8) NOT NULL default '0',
  cat_title varchar(64) NOT NULL default '',
  cat_minlevel int(11) NOT NULL default '0',
  PRIMARY KEY  (cat_id)
) TYPE=MyISAM;

CREATE TABLE vd_fsubcats (
  sub_id mediumint(8) unsigned NOT NULL auto_increment,
  sub_subid mediumint(8) NOT NULL default '0',
  sub_catid mediumint(8) NOT NULL default '0',
  sub_status int(11) NOT NULL default '0',
  sub_title varchar(64) NOT NULL default '',
  sub_des varchar(255) NOT NULL default '',
  sub_minlevel int(11) NOT NULL default '0',
  PRIMARY KEY  (sub_id)
) TYPE=MyISAM;

CREATE TABLE vd_topics (
  topic_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_minlevel int(11) NOT NULL default '0',
  topic_status int(11) NOT NULL default '0',
  topic_title varchar(64) NOT NULL default '',
  topic_text text NOT NULL,
  topic_lpdate datetime NOT NULL default '0000-00-00 00:00:00',
  topic_subcatid varchar(16) NOT NULL default '',
  topic_ownerid mediumint(8) NOT NULL default '0',
  topic_views int(64) NOT NULL default '0',
  topic_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (topic_id)
) TYPE=MyISAM;

CREATE TABLE vd_posts (
  post_id mediumint(8) unsigned NOT NULL auto_increment,
  post_text text NOT NULL,
  post_topicid varchar(16) NOT NULL default '',
  post_ownerid mediumint(8) NOT NULL default '0',
  post_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (post_id)
) TYPE=MyISAM;

CREATE TABLE vd_moderators (
  mod_id mediumint(8) unsigned NOT NULL auto_increment,
  mod_userid mediumint(8) NOT NULL default '0',
  mod_catid mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (mod_id)
) TYPE=MyISAM;