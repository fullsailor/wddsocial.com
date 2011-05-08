<?php

namespace WDDSocial;

/*
*
* Author: Anthony Colangelo (me@acolangelo.com)
*
*/
class AdminSQL{
	private $_info = array(
		
		/**
		* User queries
		*/
		
		'addUser' => "
			INSERT INTO users (typeID, firstName, lastName, email, fullsailEmail, `password`, vanityURL, bio, hometown, birthday, `datetime`)
			VALUES (:typeID, :firstName, :lastName, :email, :fullsailEmail, MD5(:password), :vanityURL, :bio, :hometown, :birthday, NOW())",
		
		'generateUserAvatar' => "
			UPDATE users
			SET avatar = MD5(CONCAT('user',id))
			WHERE id = :id",
		
		/**
		* Project Queries
		*/
		
		'addProject' => "
			INSERT INTO projects (userID, title, description, content, vanityURL, completeDate, `datetime`)
			VALUES (:userID, :title, :description, :content, :vanityURL, :completeDate, NOW())",
		
		'generateProjectVanityURL' => "
			UPDATE projects
			SET vanityURL = SUBSTRING(MD5(CONCAT('project',id)),1,6)
			WHERE id = :id",
		
		'addProjectTeanMember' => "
			INSERT INTO userProjects (userID, projectID, title)
			VALUES (:userID, :projectID, :title)",
		
		/**
		* Article Queries
		*/
		
		'addArticle' => "
			INSERT INTO articles (userID, privacyLevelID, title, description, content, vanityURL, `datetime`)
			VALUES (:userID, :privacyLevelID, :title, :description, :content, :vanityURL, NOW())",
		
		'generateArticleVanityURL' => "
			UPDATE articles
			SET vanityURL = SUBSTRING(MD5(CONCAT('article',id)),1,6)
			WHERE id = :id",
		
		'addArticleAuthor' => "
			INSERT INTO userArticles (userID, articleID)
			VALUES (:userID, :articleID)",
		
		/**
		* Event Queries
		*/
		
		'addEvent' => "
			INSERT INTO events (userID, privacyLevelID, title, description, content, vanityURL, location, startDatetime, endDatetime, `datetime`)
			VALUES (:userID, :privacyLevelID, :title, :description, :content, :vanityURL, :location, :startDatetime, DATE_ADD(:startDatetime, INTERVAL :duration HOUR), NOW());
			
			SET @last_id = LAST_INSERT_ID();
			
			UPDATE events
			SET icsUID = MD5(CONCAT(id,title,DATE_FORMAT(`datetime`, '%Y%m%dT%H%i%SZ'),'@wddsocial.com'))
			WHERE id = @last_id;",
		
		'generateEventVanityURL' => "
			UPDATE events
			SET vanityURL = SUBSTRING(MD5(CONCAT('event',id)),1,6)
			WHERE id = :id",
		
		/**
		* Job Queries
		*/
		
		'addJob' => "
			INSERT INTO jobs (userID, typeID, title, description, content, vanityURL, company, email, location, website, compensation, `datetime`)
			VALUES (:userID, :typeID, :title, :description, :content, :vanityURL, :company, :email, :location, :website, :compensation, NOW());
			
			SET @last_id = LAST_INSERT_ID();
			
			UPDATE jobs
			SET avatar = MD5(CONCAT('job',id))
			WHERE id = @last_id;",
		
		'generateJobVanityURL' => "
			UPDATE jobs
			SET vanityURL = SUBSTRING(MD5(CONCAT('job',id)),1,6)
			WHERE id = :id",
		
		/**
		* Image Queries
		*/
		
		'addImage' => "
			INSERT INTO images (userID, title, `datetime`)
			VALUES (:userID, :title, NOW());
			
			SET @last_id = LAST_INSERT_ID();
			
			UPDATE images
			SET `file` = MD5(CONCAT('image',id))
			WHERE id = @last_id;",
		
		'addProjectImage' => "
			INSERT INTO projectImages (projectID, imageID)
			VALUES (:projectID,:imageID)",
		
		'addArticleImage' => "
			INSERT INTO articleImages (articleID, imageID)
			VALUES (:articleID,:imageID)",
		
		'addEventImage' => "
			INSERT INTO eventImages (eventID, imageID)
			VALUES (:eventID,:imageID)",
		
		'addJobImage' => "
			INSERT INTO jobImages (jobID, imageID)
			VALUES (:jobID,:imageID)"
		
	);
	
	public function __get($id){
		return $this->_info[$id];
	}
	
	public function __construct(){
		
	}
	
	public function __destruct(){
		
	}
}