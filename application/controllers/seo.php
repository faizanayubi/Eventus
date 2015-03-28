<?php

/**
 * Class to Set Meta Tags and SEO elements
 *
 * @author Faizan Ayubi
 */
class SEO {

    /**
     * The title meta
     * @var string
     */
    protected static $title = 'Eventus';

    /**
     * The keywords meta
     * @var string
     */
    protected static $keywords = 'events in india, ghoomna';

    /**
     * The description meta
     * @var string
     */
    protected static $description = 'Platform to let you know where to spend time';

    /**
     * The author meta	
     * @var string
     */
    protected static $author = 'https://plus.google.com/107837531266258418226';

    /**
     * The robots meta
     * @var string
     */
    protected static $robots = 'INDEX,FOLLOW';

    /**
     * The photo meta
     * @var string
     */
    protected static $photo = CDN . 'img/logo.png';

    /**
     * Set the title
     * @param string $title The title
     */
    public static function setTitle($title) {
        self::$title = $title;
        return $title;
    }

    /**
     * Set the keywords
     * @param string $keywords List of keywords, seperated by commas.
     */
    public static function setKeywords($keywords) {
        self::$keywords = $keywords;
        return $keywords;
    }

    /**
     * Set the Description
     * @param string $description The description
     */
    public static function setDescription($description) {
        self::$description = $description;
        return $description;
    }

    /**
     * Set the author
     * @param string $author The author
     */
    public static function setAuthor($author) {
        self::$author = $author;
        return $author;
    }

    /**
     * Set the robots
     * @param string $robots The robots
     */
    public static function setRobots($robots) {
        self::$robots = $robots;
        return $robots;
    }

    /**
     * Set the photo
     * @param string $photo The photo
     */
    public static function setPhoto($photo) {
        self::$photo = $photo;
        return $photo;
    }

    /**
     * Returns the Title
     * @return string The title
     */
    public static function title() {
        return self::$title;
    }

    /**
     * Returns the keywords
     * @return string The keywords
     */
    public static function keywords() {
        return self::$keywords;
    }

    /**
     * Returns the description
     * @return string The description
     */
    public static function description() {
        return self::$description;
    }

    /**
     * Returns the Author
     * @return string The author
     */
    public static function author() {
        return self::$author;
    }

    /**
     * Returns the Robots
     * @return string The robots
     */
    public static function robots() {
        return self::$robots;
    }

    /**
     * Returns the photo
     * @return string The photo
     */
    public static function photo() {
        return self::$photo;
    }

}