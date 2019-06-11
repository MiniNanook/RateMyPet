<?php
require_once __DIR__ . '/Aplicacion.php';
require_once __DIR__ . '/Pet.php';
require_once __DIR__ . '/Usuario.php';

class Post {

    // Variables

    private $idpost; // Auto-set
    private $petid; // Auto-set
    private $userid; // Auto-set
    private $description; // User specified
    private $likes; // Auto-set
    private $repets; // Auto-set
    private $time; // Auto-set
    private $image; // Auto-set
    private $title; // Auto-set

    public function __construct($idpost, $petid, $title, $description, $likes, $repets, $time, $image) {
        $this->idpost = $idpost;
        $this->petid = $petid;
        $this->title = $title;
        $this->description = $description;
        $this->likes = $likes;
        $this->repets = $repets;
        $this->time = $time;
        $this->image = $image;
    }

    public static function buscaPost($idpost) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM posts U WHERE U.idpost = '%s'", $conn->real_escape_string($idpost));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc(); // Add following parameters
                $post = new Post($fila['idpost'], $fila['petid'], $fila['title'], $fila['description'], $fila['likes'], $fila['repets'], $fila['time'], '');
                $result = $post;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function allPosts($idPet) { // Given an Owner ID, returns a list with all the pets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM posts  WHERE petid =$idPet";
        $rs = $connect->query($sql);
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function submitPost() {
        // idpost / time / likes / repets / petid / description
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // INSERT INTO `posts` (`idpost`, `time`, `likes`, `repets`, `petid`, `description`) VALUES (NULL, '2019-04-12', '9', '7', '29', NULL);
        $this->title = str_replace("'", "\'", $this->title);
        $this->description = str_replace("'", "\'", $this->description);
        $sql = 'INSERT INTO posts VALUES (NULL, \''.$this->title.'\',\''.$this->time.'\', '.$this->likes.', '.$this->repets.', '.$this->petid.', \''.$this->description.'\', 1)';
        $rs = $conn->query($sql);
        $this->idpost = $conn->insert_id;
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public static function addValidationRow($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'INSERT INTO postvalidation VALUES ('.$id.', NULL, NULL, NULL, NULL, NULL, NULL, NULL)'; // Return current ranking
        $rs = $conn->query($sql);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteValidationRow($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM postvalidation WHERE idPost = '.$id.''; // Delete The Row
        $rs = $conn->query($sql);
        if ($rs) {
            return true;
        } else return false;
    }

    public function processImage($tmp_name, $extension) {
        $result = false;
        $path = 'upload/posts/'; // Where the file is going to be saved
        // First, delete any image that existed previously with the same name
        unlink('upload/posts/'.$this->idpost().'.jpg');
        unlink('upload/posts/'.$this->idpost().'.png');
        unlink('upload/posts/'.$this->idpost().'.jpeg');
        if (move_uploaded_file($tmp_name, $path.$this->idpost().'.'.$extension)) {
            $result = true;
        } else {
            echo 'Something went wrong...';
            echo ''.$path;
            echo ''.$path.$this->idpost().'.'.$extension;
            exit();
        }
        return $result;
    }

    public function getImageSrc() {
        // This function gets the User's image, depending on the extension, and returns a default if it doesn't exist
        $src = 'upload/posts/'; // Image directory
        if (file_exists('upload/posts/'.$this->idpost().'.jpg')) { 
            $src .= $this->idpost().'.jpg';
        } else if (file_exists('upload/posts/'.$this->idpost().'.png')) {
            $src .= $this->idpost().'.png';
        } else if (file_exists('upload/posts/'.$this->idpost().'.jpeg')) {
            $src .= $this->idpost().'.jpeg';
        } else { // Default Image
            $src .= 'default.png';
        }
        return $src;
    }

    public static function borrarPost($postid){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = "DELETE FROM likedposts where idpost = '$postid'";
        $conn->query($sql);
        $sql = "DELETE FROM postvalidation where idpost = '$postid'";
        $conn->query($sql);
        $sql = "DELETE FROM repets where idpost = '$postid'";
        $conn->query($sql);
        $sql = "DELETE FROM comments where idpost = '$postid'";
        $conn->query($sql);
        
        $sql = "DELETE FROM posts where idpost = '$postid'";
        $result = $conn->query($sql);
    }

    public function addComment($idUser, $idPost, $content) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        // INSERT INTO `posts` (`idpost`, `time`, `likes`, `repets`, `petid`, `description`) VALUES (NULL, '2019-04-12', '9', '7', '29', NULL);
        $sql = 'INSERT INTO comments VALUES (NULL, \''.$idPost.'\',\''.$idUser.'\', \''.$content.'\', 0)';
        echo ''.$sql;
        $rs = $conn->query($sql);
        $idPost = $conn->insert_id;
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }

    public function idpost() {
        return $this->idpost;
    }

    public function petid() {
        return $this->petid;
    }

    public function userid() {
        return $this->userid;
    }

    public function likes() { // Loads the amount of likes
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM likedposts WHERE idPost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($rs) {
            return ($rs->num_rows);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function repets() { // Loads the amount of repets
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM repets WHERE idPost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($rs) {
            return ($rs->num_rows);
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function time() {
        return $this->time;
    }

    public function description() {
        return $this->description;
    }

    public function title() {
        return $this->title;
    }

    public function isPending() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM posts WHERE idpost = '.$this->idpost.'';
        $rs = $connect->query($sql);
        if ($post = $rs->fetch_assoc()) {
            return ($post['pending'] == '1');
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public function displayHome($postList, $numPosts) {
        $counter = 0;
        while($counter < $numPosts && $postList->num_rows > $counter) {
            $post = $postList->fetch_assoc();
            echo Post::toString($post);
            $counter = $counter + 1;
        }
    }

    public function toString($isFull) { //
        $title = $this->title();
        $idpet = $this->petid();
        $time = $this->time();
        $likes = $this->likes();
        $description = $this->description();
        $name = Pet::buscarPet($idpet)->petName();//coger el nombre del pet de algun stitio

        $string = '<img id="post" src="'.$this->getImageSrc().'">
        <h1>Post from: <a href="petProfile.php?idPet='.$idpet.'">'.$name.'</a></h1> 
        <h2>'.$title.'</h2>
        <h2>'.$description.'</h2>';
        if ($isFull) {
            if ($likes == 1) {
                $string = $string.'<h3>'.$likes.' Like</h3>';
            } else {
                $string = $string.'<h3>'.$likes.' Likes</h3>';
            }
        }
        
        $string = $string.'<h3>Date: '.$time.'</h3>';
        return $string;
    }

    // Mod Functions - Verification

    public static function getPending() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = "SELECT * FROM posts  WHERE pending = 1";
        $rs = $connect->query($sql);
        if ($rs) {
            return $rs;
        } else {
            echo "Error al consultar la BD: (" . $connect->errno . ") " . utf8_encode($connect->error);
            exit();
        }
    }

    public static function checkSigned($mod, $post) { // Checks if a moderator has already signed the petition to verify a post
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql = 'SELECT * FROM postvalidation WHERE idPost = '.$post.' AND modId = '.$mod.'';
        $rs = $connect->query($sql);
        if ($rs->num_rows != 1) {
            return false;
        } else {
            return true;
        }
    }

    public function sign() {
        $control = Aplicacion::getSingleton();
        $connect = $control->conexionBd();
        $sql= 'INSERT INTO postvalidation VALUES ('.$this->idpost().', '.$_SESSION['user']->id().')';
        $rs = $connect->query($sql);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    // Verification

    public static function getVerificationArray($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM postvalidation WHERE idPost = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        $yes = 0;
        $no = 0;
        if ($post_ = $rs->fetch_assoc()) {
            if ($post_['userIdA'] != NULL) {
                $yes++; // One Vote if Favour
            }
            if ($post_['userIdB'] != NULL) {
                $yes++; // 
            }
            if ($post_['userIdC'] != NULL) { //
                $yes++; //
            }

            if ($post_['notAId'] != NULL) {
                $no++; // One vote not in favour
            }
            if ($post_['notBId'] != NULL) {
                $no++; // 
            }
            if ($post_['notCId'] != NULL) {
                $no++; //
            }
            $result = array();
            $result[] = $yes; // Poisitive
            $result[] = $no; // Negative
            return $result;
        } else return false;
    }

    public static function verify($id) { // Verifies a Pet
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE posts SET pending = 0 WHERE idpost = '.$id.''; // Verify
        $rs = $conn->query($sql);
        if ($rs) {
            self::deleteValidationRow($id); // No more need for the validation row to exist for this pet
            return $rs;
        } else return false;
    }

    public static function notVerify($id) { // Verifies a Pet
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'DELETE FROM posts WHERE idpost = '.$id.''; // Verify
        $rs = $conn->query($sql);
        if ($rs) {
            // ON CASCADE DELETE VERIFICATION ROW
            return $rs;
        } else return false;
    }

    public static function getNotVerified() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM posts WHERE pending = 1'; // Return current ranking
        $rs = $conn->query($sql);
        if($rs->num_rows > 0) {
            return $rs;
        } else return false;
    }

    public static function sayYes($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM postvalidation WHERE idPost = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        if ($rs->num_rows < 1) { // No validation created yet
            self::addValidationRow($id);
        }
        $rs = $conn->query($sql);
        if ($post_ = $rs->fetch_assoc()) {
            if ($post_['userIdA'] == NULL) {
                $sql = 'UPDATE postvalidation SET userIdA = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Accept
            } else if ($post_['userIdB'] == NULL) {
                $sql = 'UPDATE postvalidation SET userIdB = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Accept
            } else if ($post_['userIdC'] == NULL) { // This is the last Validation necessary
                $sql = 'UPDATE postvalidation SET userIdC = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Accept
            }
            $rs = $conn->query($sql); // Execute
            if ($rs) {
                return true;
            }
            else return false;
        } else {
            return false;
        }
    }

    public static function sayYesMod($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE postvalidation SET modId = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        if ($rs) {
            Post::verify($id);
            return true;
        } else return false;
    }

    public static function sayNo($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'SELECT * FROM postvalidation WHERE idPost = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        if ($rs->num_rows < 1) { // No validation created yet
            self::addValidationRow($id);
        }
        $rs = $conn->query($sql);
        if($post_ = $rs->fetch_assoc()) {
            if ($post_['notAId'] == NULL) {
                $sql = 'UPDATE postvalidation SET notAId = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Deny
            } else if ($post_['notBId'] == NULL) {
                $sql = 'UPDATE postvalidation SET notBId = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Deny
            } else if ($post_['notCId'] == NULL) { // Deny
                $sql = 'UPDATE postvalidation SET notCId = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Deny
            }
            $rs = $conn->query($sql); // Execute
            if ($rs) return true;
            else return false;
        } else return false;
    }

    public static function sayNoMod($id) {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $sql = 'UPDATE postvalidation SET modId = '.$_SESSION['user']->id().' WHERE idPost = '.$id.''; // Return current ranking
        $rs = $conn->query($sql);
        if ($rs) {
            Post::notVerify($id);
            return true;
        } else return false;
    }

}
