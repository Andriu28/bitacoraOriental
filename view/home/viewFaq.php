
<?php  
    // Itera sobre cada elemento en los datos
    foreach ($dataToView["data"]["faq"] as $data) { ?>
        
        <div class="faq_item">
            <button class="faq_button">
                <?php echo $data->query; ?>
                <svg class="faq_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: currentColor; margin-left: 20px;">
                    <path d="M12.707 17.293 8.414 13H18v-2H8.414l4.293-4.293-1.414-1.414L4.586 12l6.707 6.707z"></path>
                </svg>
            </button>
            <div class="faq_content">
                <p><?php echo $data->respond; ?></p>
            </div>
        </div>

    <?php  
    }

?>

