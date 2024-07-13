<span class="notify" id="notify">
    <a data-notify="0"></a>
    <!-- <a data-notify="1"><i class="fas fa-bell"></i></a> -->
</span>

<script>

    jQuery(function($){

        let notify  = $(`#notify`)
        let enable  = notify.find(`a`)

        if(enable.data(`notify`)){
            enable.html(`<i class="fas fa-bell-slash"></i>`)
        
        }else{
            enable.html(`<i class="fas fa-bell"></i>`)
        }

        notify.on(`click`, function(){
            enable.data(`notify`) = !enable.data(`notify`)

        });

    });

</script>

<style>
    #notify {
        background-color: gold;
        width: 50px;
        height: 50px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        border-radius: 30px;
        background-color: #0d6efd;
    }

    #notify a{
        color:white
    }
</style>