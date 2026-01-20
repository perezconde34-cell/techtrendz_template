<?php
require_once 'lib/config.php';
require_once 'lib/session.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';
require_once 'templates/header.php';


$errors = [];
$messages = [];


if (isset($_POST['loginUser'])) {




    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {
        $errors[] = "vous devez metrre un email et un mot de passe";
    } else {

        $user = verifyUserLoginPassword($pdo, $email, $password);

        if ($user !== false) {


            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role']
            ];


            if ($user['role'] === 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $errors[] = "Utilisateur ou mot de passe incorrect";
        }
    }
}


require_once 'lib/user.php';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($email && $password) {
    $user = verifyUserLoginPassword($pdo, 'alice@gmail.com', 'ABC123');

    if ($user !== false) {
        echo "Connexion réussie";
    } else {
        echo "Email ou mot de passe incorrect";
    }
} else {
    echo "Veuillez remplir les champs manquants";
}





?>
<h1>Login</h1>

<?php // @todo afficher les erreurs avec la structure suivante :
/*
        <div class="alert alert-danger" role="alert">
            Utilisatuer ou mot de passe incorrect
        </div>
        */
?>

<form method="POST">
    <div class="mb-3">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de psse</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">

</form>

<?php
require_once 'templates/footer.php';
?>