<?php
class queue_status
{
    public $connect;
    public $timestamp;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function getCurrentTimestamp()
    {
        date_default_timezone_set("AFRICA/LAGOS");
        $strToTime = strtotime("Now");
        $this->timestamp = date("Y-m-d H:i:s", $strToTime);
    }

    public function selectQueue()
    {
        $this->getCurrentTimestamp();

        $sql = $this->connect->query("SELECT * FROM `consultation` INNER JOIN `patient` ON `consultation`.patient_id = `patient`.patient_id WHERE consultation.`date_time` > CURRENT_DATE AND status = 'On queue'");
        return $sql;
    }
}
class login
{
    public $connect;
    public $email;
    public $password;
    public $whoIsAuthorized;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserInputs()
    {
        $this->email = htmlspecialchars($_POST["email"]);
        $this->password = htmlspecialchars($_POST["password"]);
    }

    public function checkAdminEmail()
    {
        $selectingFromAdmin = $this->connect->query("SELECT * FROM `admin` WHERE admin_email = '$this->email'");
        $selectingFromUser = $this->connect->query("SELECT * FROM `users` WHERE email = '$this->email'");

        if ($selectingFromAdmin->num_rows > 0) {
            $result = $selectingFromAdmin->fetch_assoc();
            $dbpassword = $result["password"];
            $this->whoIsAuthorized = 'Admin';
            return $dbpassword;
        } else if ($selectingFromUser->num_rows > 0) {
            $result = $selectingFromUser->fetch_assoc();
            $dbpassword = $result["password"];
            $this->whoIsAuthorized = 'User';
            return $dbpassword;
        } else {
            $this->errorMessage('Email doesn\'t exist!');
            return false;
        }
    }

    public function checkAdminPassword($dbpassword)
    {
        $result = password_verify($this->password, $dbpassword);
        if ($result) {
            return true;
        } else {
            $this->errorMessage('Incorrect Password!');
            return false;
        }
    }

    public function redirection()
    {
        if ($this->whoIsAuthorized === 'Admin') {
            $this->redirectToAdminPage();
        } else if ($this->whoIsAuthorized === 'User') {
            $this->redirectToUserPage();
        }
    }

    public function redirectToUserPage()
    {
        $sql = $this->connect->query("SELECT * FROM `users` WHERE email = '$this->email'");
        $user_detail = $sql->fetch_assoc();

        // Passing User detail to the next page i.e Dashboard base on role
        $role = $user_detail['role'];

        switch ($role) {
            case 'Doctor':
                $_SESSION['doctor_id'] = $user_detail['user_id'];

                // Displaying 'Login success' message
                $this->displayLoginSuccessMessage("./doctor/dashboard.php");
                break;

            case 'Nurse':
                $_SESSION['nurse_id'] = $user_detail['user_id'];

                // Displaying 'Login success' message
                $this->displayLoginSuccessMessage("./nurse/dashboard.php");
                break;
        }
    }

    public function redirectToAdminPage()
    {
        $sql = $this->connect->query("SELECT * FROM `admin` WHERE admin_email = '$this->email'");

        // Passing Admin detail to the next page i.e Dashboard
        $admin_detail = $sql->fetch_assoc();
        $_SESSION['admin_id'] = $admin_detail['admin_id'];

        // Displaying 'Login success' message
        $this->displayLoginSuccessMessage("./admin/dashboard.php");
    }

    public function displayLoginSuccessMessage(string $href)
    {
        echo '
        <div class="position-absolute w-100 h-100  d-flex justify-content-center align-items-center success-message">
            <img src="./images/success gif.gif" class="w-25" alt="Success Message">
        </div>
            ';
        echo "
            <script>
                setInterval(()=>{
                    window.location.href='" . $href . "';
                },3000);
            </script>
        ";
    }

    public function errorMessage($message)
    {
        echo '
        <div class="alert alert-danger position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
        echo '
            <script>
                setInterval(()=>{
                    let invalidCredentialElement = document.querySelector(".js-alert");

                    invalidCredentialElement.style.display="none";
                },2500);

            </script>
        ';
    }
}


//ADMIN PAGE CLASSES START
class admin
{
    public $connect;
    public $admin_id;
    public $admin_email;


    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserDetail($admin_id)
    {
        $this->admin_id = $admin_id;

        $sql = $this->connect->query("SELECT * FROM `admin` WHERE admin_id = $this->admin_id");
        $result = $sql->fetch_assoc();
        $this->admin_email = $result["admin_email"];
    }

    public function redirectToLogin()
    {
        echo "
            <script>
                alert('You are yet to login!');
                window.location.href='../login.php';
            </script>
        ";
        die();
    }
}

class dashboard extends admin
{
    public $noOfDoctors;
    public $noOfNurses;
    public $noOfAuthorizedUsers;
    public $noOfPatientInQueue;
    public $timestamp;

    public function calcNoOfDoctors()
    {
        $sql = $this->connect->query("SELECT COUNT(user_id) AS noOfDoctors FROM `users` WHERE role = 'Doctor'");
        $result = $sql->fetch_assoc();
        $this->noOfDoctors = $result["noOfDoctors"] ?? 0;
    }

    public function calcNoOfNurses()
    {
        $sql = $this->connect->query("SELECT COUNT(user_id) AS noOfNurses FROM `users` WHERE role = 'Nurse'");
        $result = $sql->fetch_assoc();
        $this->noOfNurses = $result["noOfNurses"] ?? 0;
    }

    public function calcNoOfAuthorizedUsers()
    {
        $sql = $this->connect->query("SELECT COUNT(user_id) AS noOfAuthorizedUsers FROM `users`");
        $result = $sql->fetch_assoc();
        $this->noOfAuthorizedUsers = $result["noOfAuthorizedUsers"] ?? 0;
    }

    public function calcNoOfPatientInQueue()
    {
        $this->getCurrentTimestamp();

        $sql = $this->connect->query("SELECT COUNT(queue_id) AS noOfPatientInQueue FROM `consultation` WHERE date_time > CURRENT_DATE AND status = 'On queue'");
        $result = $sql->fetch_assoc();
        $this->noOfPatientInQueue = $result["noOfPatientInQueue"] ?? 0;
    }

    public function getCurrentTimestamp()
    {
        date_default_timezone_set("AFRICA/LAGOS");
        $strToTime = strtotime("Now");
        $this->timestamp = date("Y-m-d H:i:s");
    }
}

class add_doctor extends admin
{
    public $firstname;
    public $lastname;
    public $othername;
    public $email;
    public $password;
    public $specialization;

    public function collectUserInputs()
    {
        $this->firstname = htmlspecialchars($_POST["firstname"]);
        $this->lastname = htmlspecialchars($_POST["lastname"]);
        $this->othername = htmlspecialchars($_POST["othername"]);
        $this->email = htmlspecialchars($_POST["email"]);
        $this->password = htmlspecialchars($_POST["password"]);
        $this->specialization = htmlspecialchars($_POST["specialization"]);
    }

    public function checkIfEmailExist()
    {
        $sql = $this->connect->query("SELECT * FROM `users` WHERE email = '$this->email'");
        if ($sql->num_rows > 0) {
            $this->errorMessage("Email already exist!");
            return true;
        } else {
            return false;
        }
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `users` (firstname,lastname,othername,email,password,specialization,role) VALUES('$this->firstname','$this->lastname','$this->othername','$this->email','$this->password','$this->specialization','Doctor')");

        if ($sql) {
            $this->successMessage("Doctor Added!");
        } else {
            $error_message = '' . $this->connect->error;
            $this->errorMessage($error_message);
        }
    }


    public function successMessage(string $message)
    {
        echo '
        <div class="alert alert-success position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
        echo '
            <script>
                setInterval(()=>{
                    let invalidCredentialElement = document.querySelector(".js-alert");

                    invalidCredentialElement.style.display="none";
                    window.location.href="users.php";
                },2500);

            </script>
        ';
    }

    public function errorMessage(string $message)
    {
        echo '
        <div class="alert alert-danger position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
        echo '
            <script>
                setInterval(()=>{
                    let invalidCredentialElement = document.querySelector(".js-alert");

                    invalidCredentialElement.style.display="none";
                },2500);

            </script>
        ';
    }
}

class add_nurse extends add_doctor
{
    public $firstname;
    public $lastname;
    public $othername;
    public $email;
    public $password;

    public function collectUserInputs()
    {
        $this->firstname = htmlspecialchars($_POST["firstname"]);
        $this->lastname = htmlspecialchars($_POST["lastname"]);
        $this->othername = htmlspecialchars($_POST["othername"]);
        $this->email = htmlspecialchars($_POST["email"]);
        $this->password = htmlspecialchars($_POST["password"]);
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `users` (firstname,lastname,othername,email,password,role) VALUES('$this->firstname','$this->lastname','$this->othername','$this->email','$this->password','Nurse')");

        if ($sql) {
            $this->successMessage("Nurse Added!");
        } else {
            $error_message = '' . $this->connect->error;
            $this->errorMessage($error_message);
        }
    }
}

class users extends admin
{
    public function selectUsers()
    {
        $sql = $this->connect->query("SELECT * FROM `users`");
        return $sql;
    }

    public function processDeleteUser()
    {
        if (isset($_GET["user_id"])) {
            $user_id = $_GET["user_id"];
            $sql = $this->connect->query("DELETE FROM `users` WHERE user_id = $user_id");

            if ($sql) {
                header("location:users.php");
            }
        }
    }
}
//ADMIN PAGE CLASSES START


//NURSE PAGE CLASSES START
class nurse
{
    public $connect;
    public $user_id;
    public $firstname;
    public $lastname;
    public $othername;
    public $user_email;
    public $specialization;


    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserDetail($user_id)
    {
        $this->user_id = $user_id;

        $sql = $this->connect->query("SELECT * FROM `users` WHERE user_id = $this->user_id");
        $result = $sql->fetch_assoc();
        $this->firstname = $result["firstname"];
        $this->lastname = $result["lastname"];
        $this->othername = $result["othername"];
        $this->user_email = $result["email"];
        $this->specialization = $result["specialization"];
    }

    public function redirectToLogin()
    {
        echo "
            <script>
                alert('You are yet to login!');
                window.location.href='../login.php';
            </script>
        ";
        die();
    }
}

class nurse_patient extends nurse
{
    public $fullname;
    public $email;
    public $phone_number;
    public $dob;
    public $address;
    public $gender;

    public function collectInputs()
    {
        $this->fullname = htmlspecialchars($_POST["fullname"]);
        $this->email = htmlspecialchars($_POST["email"]);
        $this->phone_number = htmlspecialchars($_POST["phone_number"]);
        $this->dob = htmlspecialchars($_POST["dob"]);
        $this->address = htmlspecialchars($_POST["address"]);
        $this->gender = htmlspecialchars($_POST["gender"]);
    }

    public function checkIfEmailExist()
    {
        $sql = $this->connect->query("SELECT * FROM `patient` WHERE patient_email = '$this->email'");
        if ($sql->num_rows > 0) {
            $this->Message("Email already exist!", "error");
            return true;
        } else {
            return false;
        }
    }


    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `patient` (patient_fullname,patient_email,patient_phone_no,patient_dob,patient_address,patient_gender) VALUES('$this->fullname','$this->email','$this->phone_number','$this->dob','$this->address','$this->gender')");

        if ($sql) {
            $this->Message("Patient Added!", "success");
        } else {
            $error_message = '' . $this->connect->error;
            $this->Message($error_message, "error");
        }
    }

    public function Message(string $message, string $type)
    {
        $type = ($type === "success") ? "success" : "danger";
        echo '
        <div class="alert alert-' . $type . ' position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
        echo '
            <script>
                setInterval(()=>{
                    let invalidCredentialElement = document.querySelector(".js-alert");

                    invalidCredentialElement.style.display="none";
                },2500);

            </script>
        ';
    }

    public function selectPatients()
    {
        $sql = $this->connect->query("SELECT * FROM `patient`");
        return $sql;
    }
}

class nurse_consultation extends nurse
{
    public $patient_id;
    public $reason;
    public $queue_id;

    public function selectPatients()
    {
        $sql = $this->connect->query("SELECT * FROM `patient`");
        return $sql;
    }

    public function collectInputs()
    {
        $this->patient_id = htmlspecialchars($_POST["patient_id"]);
        $this->reason = htmlspecialchars($_POST["reason"]);
    }

    public function checkIfPatientIsOnQueue()
    {
        $sql = $this->connect->query("SELECT * FROM `consultation` WHERE patient_id = $this->patient_id AND consultation.`date_time` > CURRENT_DATE  AND status = 'On queue'");

        if ($sql->num_rows > 0) {
            $this->Message("Patient is already in queue!", "error");
            return true;
        } else {
            return false;
        }
    }

    public function generateQueueID()
    {
        date_default_timezone_set("AFRICA/LAGOS");
        $strtotime = strtotime("Now");
        $date = date("dHs", $strtotime);
        $this->queue_id = "CONS" . $date . $this->patient_id;
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `consultation` (queue_id,patient_id,reason,status) VALUES('$this->queue_id','$this->patient_id','$this->reason','On queue')");

        if ($sql) {
            $this->Message("Consultation Booked! Queue ID: $this->queue_id", "success");
        } else {
            $error_message = '' . $this->connect->error;
            $this->Message($error_message, "error");
        }
    }

    public function Message(string $message, string $type)
    {
        $type = ($type === "success") ? "success" : "danger";
        echo '
        <div class="alert alert-' . $type . ' position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
    }
}

//NURSE PAGE CLASSES END


//DOCTOR PAGE CLASSES START
class doctor
{
    public $connect;
    public $user_id;
    public $firstname;
    public $lastname;
    public $othername;
    public $user_email;
    public $specialization;


    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserDetail($user_id)
    {
        $this->user_id = $user_id;

        $sql = $this->connect->query("SELECT * FROM `users` WHERE user_id = $this->user_id");
        $result = $sql->fetch_assoc();
        $this->firstname = $result["firstname"];
        $this->lastname = $result["lastname"];
        $this->othername = $result["othername"];
        $this->user_email = $result["email"];
        $this->specialization = $result["specialization"];
    }

    public function redirectToLogin()
    {
        echo "
            <script>
                alert('You are yet to login!');
                window.location.href='../login.php';
            </script>
        ";
        die();
    }

    public function setUnattendedToNotattended()
    {
        $this->connect->query("UPDATE `consultation` SET status = 'Was not attended' WHERE consultation.`date_time` < CURRENT_DATE AND status = 'On queue'");
    }
}

class doctor_queue extends doctor
{
    public $timestamp;

    public function getCurrentTimestamp()
    {
        date_default_timezone_set("AFRICA/LAGOS");
        $strToTime = strtotime("Now");
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function selectQueue()
    {
        $this->getCurrentTimestamp();

        $sql = $this->connect->query("SELECT * FROM `consultation` INNER JOIN `patient` ON `consultation`.patient_id = `patient`.patient_id WHERE consultation.`date_time` > CURRENT_DATE AND status = 'On queue'");
        return $sql;
    }

    public function checkIfSomeoneIsCalled()
    {
        $sql = $this->connect->query("SELECT * FROM `consultation` INNER JOIN `patient` ON `consultation`.patient_id = `patient`.patient_id WHERE consultation.`date_time` > CURRENT_DATE AND status = 'called'");
        if ($sql->num_rows > 0) {
            $this->Message("A Patient is already in consultation!", "error");
            return true;
        } else {
            return false;
        }
    }

    public function processcallPatient()
    {
        $queue_id = $_GET["queue_id"];

        $sql = $this->connect->query("UPDATE `consultation` SET status = 'called' WHERE queue_id = '$queue_id'");

        if ($sql) {
            $this->Message("Patient can now come in!", "success");
        } else {
            $error_message = '' . $this->connect->error;
            $this->Message($error_message, "error");
        }
    }

    public function Message(string $message, string $type)
    {
        $type = ($type === "success") ? "success" : "danger";
        echo '
        <div class="alert alert-' . $type . ' position-absolute top-0 end-0 js-alert">
            ' . $message . ' 
            <button type="button" class="btn" aria-label="Close" data-bs-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';
        echo '
            <script>
                setInterval(()=>{
                    let invalidCredentialElement = document.querySelector(".js-alert");

                    invalidCredentialElement.style.display="none";
                },2500);

            </script>
        ';
    }
}

class doctor_consultations extends doctor_queue
{
    public function selectQueue()
    {
        $this->getCurrentTimestamp();

        $sql = $this->connect->query("SELECT * FROM `consultation` INNER JOIN `patient` ON `consultation`.patient_id = `patient`.patient_id WHERE consultation.`date_time` > CURRENT_DATE AND status = 'called'");
        return $sql;
    }

    public function markPatientAsDone()
    {
        $queue_id = $_GET["queue_id"];

        $sql = $this->connect->query("UPDATE `consultation` SET status = 'Done' WHERE queue_id = '$queue_id'");

        if ($sql) {
            $this->Message("Consultation marked as done!", "success");
        } else {
            $error_message = '' . $this->connect->error;
            $this->Message($error_message, "error");
        }
    }

    public function selectConsultations()
    {
        $sql = $this->connect->query("SELECT * FROM `consultation` INNER JOIN `patient` ON `consultation`.patient_id = `patient`.patient_id");
        return $sql;
    }
}

//DOCTOR PAGE CLASSES END