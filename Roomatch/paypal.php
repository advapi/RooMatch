<?php
    include("templates/header.php");
    require_once("includes/db.inc.php");
    $sql = "SELECT * FROM users WHERE id=".$_SESSION['id'].";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
?>
        <section class="container mt-5 pt-5">
            <div id="container mt-5">
                <div class="col-6 m-auto text-center">
                    <?php
                        echo "<a href=\"javascript:history.go(-1)\" class='btn btn-info'>חזרה לעמוד הקודם</a>";
                    ?>
                </div>
                <div class="productBlock mt-3">
                    <?php 
                        if($row['status'] == 1){
                            echo "<h2 dir='rtl' class='mt-5'> כבר יש לך חשבון פרימיום. אתה הכי משודרג שיש :)</h2>";
                        }
                        else{
                            if (isset($_GET["needtoupgrade"])){ ?>
                                <p>עברת את המכסה החינמית שניתנה לך. כדי להמשיך לפרסם מודעות עליך לשדרג לחשבון פרימיום</p>    
                            <?php } ?>
                            <p>לשדרוג התכנית נדרש תשלום בסך 65 שקלים חדשים, תשלום זה מאפשר לך להינות משירותים נוספים ללא הגבלה</p>
                            <p> מנוי פרימיום באתר יעניק לך גישה חופשית לכל התכנים וחווית משתמש נקייה ונוחה</p>
                            <p>Buy Now לחצו על כפתור paypal למעבר לתשלום על חשבון פרימיום באמצעות </p>
                </div>
            </div>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                    </div>
                </div>
                <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=ILS" data-sdk-integration-source="button-factory"></script>
                <script>
                    function initPayPalButton() {
                        paypal.Buttons({
                                style: {
                                shape: 'pill',
                                color: 'blue',
                                layout: 'horizontal',
                                label: 'paypal',
                            },
                
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{"description":"תשלום עבור מנוי שנתי","amount":{"currency_code":"ILS","value":65}}]
                                });
                            },
                    
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    window.location.replace("https://advapi.mtacloud.co.il?success");
                                });
                            },
                    
                            onError: function(err) {
                                console.log(err);
                            }
                        }).render('#paypal-button-container');
                    }
                    initPayPalButton();
                </script> 
                    <?php } ?>
        </section>
    </body>
</html>