<?php
$path = "/tms";
$page = "projects";


if (isset($_GET["slug"]) && strlen(trim($_GET["slug"])) > 5) {
    $slug = $_GET["slug"];
}



use app\utils\Helper;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




include '../../vendor/autoload.php';


$user = [];

session_start();
if (isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] && isset($_SESSION["user"]) && is_array($_SESSION["user"]) && count($_SESSION["user"]) == 9) {

    $user = $_SESSION["user"];
} else {
    header("location: ../login.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account - TMS</title>
    <link rel="stylesheet" href="../../static/styles/dashboard.css">
</head>

<body>
    <div class="container">
        <?php include_once('./include/header.php') ?>
        <main>
            <header>
                <div class="bars">
                    <svg id="openMenu" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                    <h1>Task</h1>
                </div>
                <div class="side_menu">
                    <a href="./create-project.php" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span>Start a project</span>
                    </a>
                    <a href="./setting.php">
                        <div class="image_holder">
                            <?php
                            // $pic = $threat["user_picture"];
                            // if ($pic !== NULL && strlen(trim($pic)) > 9) {
                            //     echo " <img src='" . Helper::loadImage($pic) . "' alt='' /> ";
                            // } else echo Helper::getInitialNames($threat["user_fullname"]);
                            echo Helper::getInitialNames("Amaka Emmanuel");
                            ?>
                        </div>
                    </a>
                </div>

            </header>
            <div class="content">
                <section id="task">
                    <div class="task_heading">
                        <h2> Task title</h2>
                        <p>Description lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam quidem esse magni quae accusamus, iure laboriosam provident enim, quia, eius ipsa voluptatem expedita? Debitis ducimus voluptatum molestias, dolor commodi sint.</p>
                        <div class="attachments">
                            <div class="head">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                                <span>Attachments</span>
                            </div>
                            <div class="attachment_list">
                                <div class="attachment_item">
                                    Attachment 1
                                </div>
                                <div class="attachment_item">
                                    Attachment 2
                                </div>
                                <div class="attachment_item">
                                    Attachment 3
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="extra_info">
                        <div class="info_list">
                            <span>Assignee</span>
                            <strong>
                                @ernest
                            </strong>
                        </div>
                        <div class="info_list">
                            <span>Deadline</span>
                            <strong>12 Sept 2024</strong>
                        </div>

                        <div class="info_list">
                            <span>Status</span>
                            <label>Unstarted</label>
                        </div>

                        <div class="info_list">
                            <span>Action</span>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061A1.125 1.125 0 0 1 3 16.811V8.69ZM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 0 1 0 1.954l-7.108 4.061a1.125 1.125 0 0 1-1.683-.977V8.69Z" />
                                </svg>
                                Move to In-Progress
                            </a>
                        </div>
                    </div>

                    <div class="tabs">
                        <div class="task_tab">
                            <div class="tab_item active" id="subTask" data-id="subTask">
                                <b data-id="subTask">Subtasks</b>
                                <span data-id="subTask">2</span>
                            </div>
                            <div class="tab_item" id="comment" data-id="comment">
                                <b data-id="comment">Comments</b>
                                <span data-id="comment">1</span>
                            </div>
                            <div class="tab_item" id="message_" data-id="message_">
                                <b data-id="message_">Message</b>
                            </div>
                        </div>
                        <div class="task_tab_details">
                            <div class="task_subtask active" id="subTask_details">
                                <ul>
                                    <li>
                                        <div class="custom-checkbox">
                                            <input type="checkbox" checked id="subtask_1" name="subtask">
                                            <label for="subtask_1"></label>
                                        </div>
                                        <p class="del">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi error consequatur dolor sit amet consectetur adipisicing elit. Nisi error consequatur volu..!</p>
                                    </li>
                                    <li>
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="subtask" name="subtask">
                                            <label for="subtask"></label>
                                        </div>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi error consequatur voluptas!</p>
                                    </li>
                                </ul>
                                <form action="" method="post">
                                    <input type="text" name="new_sub_task" id="new_sub_task" placeholder="Type in the subtask accordingly...">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="task_comment" id="comment_details">
                                <ul>
                                    <li>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus optio architecto omnis, soluta iste eum incidunt necessitatibus modi qui fugiat, ducimus illum ipsam, dolores dolorum alias? Doloremque quas laudantium perspiciatis.</p>
                                        <div class="wrapper">
                                            <div class="user">
                                                <div class="image_holder">ER</div>
                                                <div class="info">
                                                    <strong>Ernest Ramson</strong>
                                                    <span>23 min ago</span>
                                                </div>
                                            </div>
                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                            </svg>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.res dolorum alium perspiciatisperspici atisperspiciatispersp iciatis.</p>
                                        <div class="wrapper">
                                            <div class="user">
                                                <div class="image_holder"> <img src="../../static/images/no-image.png" alt=""> </div>
                                                <div class="info">
                                                    <strong>Zaria Mbam</strong>
                                                    <span>13 min ago</span>
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                            </svg>
                                        </div>
                                    </li>
                                </ul>
                                <form action="" method="post">
                                    <input type="text" name="new_sub_task" id="add_comment" placeholder="Enter your comment, @ to mention your team member...">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="task_message" id="message_details">
                                <ul>
                                    <li>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus optio architecto omnis, soluta iste eum incidunt necessitatibus modi qui fugiat, ducimus illum ipsam, dolores dolorum alias? Doloremque quas laudantium perspiciatis.</p>
                                        <div class="user">
                                            <div class="info">
                                                <div class="image_holder">ER</div>
                                                <strong>Ernest Ramson</strong>
                                            </div>
                                            <span>23 min ago</span>
                                        </div>
                                    </li>
                                    <li>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.res dolorum alium perspiciatisperspici atisperspiciatispersp iciatis.</p>
                                        <div class="user">
                                            <div class="info">
                                                <div class="image_holder"> <img src="../../static/images/no-image.png" alt=""> </div>
                                                <strong>Zaria Mbam</strong>
                                            </div>
                                            <span>13 min ago</span>
                                        </div>
                                    </li>
                                </ul>
                                <form action="" method="post">
                                    <textarea name="task_message" id="task_message" cols="30" rows="5" placeholder="Add a message to this task"></textarea>
                                    <button type="submit">
                                        Send Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>






                </section>
            </div>

            <footer>
                &copy; <?php echo date("Y") ?> -- Task Management System (TMS)
            </footer>
        </main>
    </div>

</body>


<script>
    const closeMenu = document.querySelector("#closeMenu");
    const openMenu = document.querySelector("#openMenu");

    openMenu.addEventListener("click", function() {
        document.querySelector("aside").classList.toggle("showMenu");
    });
    closeMenu.addEventListener("click", function() {
        document.querySelector("aside").classList.toggle("showMenu");
    });


    const tab_item = document.querySelectorAll(".tab_item");

    for (let i = 0; i < tab_item.length; i++) {
        tab_item[i].addEventListener('click', function(e) {
            console.log(e.target.getAttribute('data-id'))

            switch (e.target.getAttribute('data-id')) {

                case 'comment':
                    document.querySelector('#subTask_details').classList.remove('active');
                    document.querySelector('#comment_details').classList.add('active');
                    document.querySelector('#message_details').classList.remove('active');
                    document.querySelector('#subTask').classList.remove('active');
                    document.querySelector('#comment').classList.add('active');
                    document.querySelector('#message_').classList.remove('active');

                    break;
                case 'message_':
                    document.querySelector('#subTask_details').classList.remove('active');
                    document.querySelector('#comment_details').classList.remove('active');
                    document.querySelector('#message_details').classList.add('active');
                    document.querySelector('#subTask').classList.remove('active');
                    document.querySelector('#comment').classList.remove('active');
                    document.querySelector('#message_').classList.add('active');
                    break;

                default:
                    document.querySelector('#subTask_details').classList.add('active');
                    document.querySelector('#comment_details').classList.remove('active');
                    document.querySelector('#message_details').classList.remove('active');
                    document.querySelector('#subTask').classList.add('active');
                    document.querySelector('#comment').classList.remove('active');
                    document.querySelector('#message_').classList.remove('active');
                    break;
            }
        })

    }


    // document.addEventListener("DOMContentLoaded", () => {
    //     const innerLines = document.querySelectorAll('.inner-line');

    //     innerLines.forEach(innerLine => {
    //         const percentage = innerLine.getAttribute('percentage');
    //         if (percentage) {
    //             innerLine.style.setProperty('--percentage-width', percentage);
    //         }
    //     });
    // });
</script>

</html>