<?php
require 'db_conn.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body style="background: blue;">
    <h1></h1>
    <div class="maim-section">
        <div class="add-section">
            <form action="" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){?>
                    <input  type="text"
                            name="title"
                            style="border-color: #ff6666;"
                            placeholder="This field is required"/>
                    <button type="submit">Add &nbsp; <span>&#43;</span></button>

                <?php }else {?>
                    <input type="text"
                            name="title"
                            placeholder="What do you need to do?" />
                    <button type="submit">Add &nbsp;<span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php
            $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-todo-section" style="background: #fff;
    margin: 30px auto;
    padding: 10px;
    border-radius: 5px">
            <?php if($todos->rowCount() <= 0){?>
            <div class="todo-item">
                <div class="empty">
                    <img src="img/bc9d09b0ea186165ef43f68e3063f7b2.gif" alt="" width="100%">
                </div>
            </div>
            <?php } ?>
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="todo-item">
                <span id="<?php echo $todo['id'];?>" 
                      class="remove-to-do">x</span>
                <?php if($todo['checked']){ ?>
                    <input type="checkbox"
                        class="check-box"
                        data-todo-id ="<?php echo $todo['id']; ?>"
                        chacked />
                    <h2 class="checked"><?php echo $todo['title'] ?></h2>
                <?php } else { ?>
                    <input type="checkbox"
                        data-todo-id ="<?php echo $todo['id']; ?>"
                        class="check-box">
                    <h2 ><?php echo $todo['title']?></h2>
                <?php } ?>
                <br>
                <small>create: 21/11/2022 <?php echo $todo['date_time']?></small>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');

                $.post("app/remove.php",
                {
                    id: id
                },
                (data) =>{
                    if(data){
                        $(this).parent().hide(600);
                    }
                }
                );
            });

            $(".check-box").click(function(e){
            const id = $(this).attr('data-todo-id');

            $.post('app/check.php',
                {
                    id: id
                },
                (data) => {
                    if(data != 'error'){
                        const h2 = $(this).next();
                        if(data === '1'){
                            h2.removeClass('checked');
                        }else {
                            h2.addClass('checked');
                        }
                    }
                }
            );
        });
    });

    </script>
  </body>
</html>