<!doctype html>
<html>
    <head> 
        <title>Yujeong's workshop</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />
        <meta name="author" content="Yujeong" />
        <meta name="keywords" content="개발자, ui/ux, 프론트엔드, front-end, back-end, 백엔드, 풀스택, full stack, 포트폴리오" />
        <meta name="description" content="웹포트폴리오" />
        <meta property="og:title" content="Yujeong's workshop" />
        <meta property="og:url" content="http://dbwjd201166.dothome.co.kr" />
        <meta property="og:keywords" content="개발자, ui/ux, 프론트엔드, front-end, back-end, 백엔드, 풀스택, full stack, 포트폴리오" />
        <meta property="og:description" content="웹포트폴리오" />
        <meta property="og:image" content="http://ece123.dothome.co.kr/images/og.jpg" />
        <link href="css/common.css" rel="stylesheet" />
        <?
        $curPage =  basename($_SERVER['PHP_SELF']);
        $curPage = str_replace(".php", ".css", $curPage);
        if(file_exists("css/".$curPage)) {
            echo "<link href='css/{$curPage}' rel='stylesheet' />";
        }
        ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/8851690f85.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <header class="bg-light shadow pb-2">
            <div class="container text-end mt-3">
                <nav id="gnb">
                <?
                    if($_SESSION['userlv'] > 0){
                ?>
                        <a href="logout.php"><i class="fa fa-sign-out"></i> Sign out</a>
                        <span class="badge bg-primary">
                            <?
                            if($_SESSION['userlv'] >= 9){
                                $level = "관리자";
                            }else{
                                $level = "lv".$_SESSION['userlv'];
                            }
                            echo "{$_SESSION['userid']}
                            ({$_SESSION['username']}-{$level})";   
                            ?> 
                        </span>
                    <?    
                    }else{
                    ?>    
                        <a href="login.php"><i class="fa fa-sign-in"></i> Sign in</a> |
                        <a href="join.php"><i class="fas fa-user-plus"></i> Create account</a>
                    <?
                    }
                    ?>
                </nav> 
            </div>
            <div class="container overflow-auto">
                <h1 class="float-start"><a href="index.php" class="text-dark">Yujeong</a></h1>
                <nav class="float-end" id="lnb">
                    <div class="btn-group mt-2">
                        <a href="intro.php" class="btn btn-primary">Intro</a>
                        <a href="skills.php" class="btn btn-primary">Skills</a>
                        <a href="list.php?bo=works" class="btn btn-primary">Works</a>
                        <a href="contact.php" class="btn btn-primary">Contact</a>
                    </div>
                </nav>
            </div>
        </header>
        
        <section class="py-3">