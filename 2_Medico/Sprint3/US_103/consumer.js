const dbConnection = require('./connectionDB');

const connection = dbConnection();

var kafka = require('kafka-node'),
Consumer = kafka.Consumer,
client = new kafka.KafkaClient(),
consumer = new Consumer(
    client,
    [
        { topic: 'det_medico', partition: 0 }
    ],
    {
        autoCommit: false
    }
);

consumer.on('message', function (message) {
   
    switch(message.value['type']){
        case 'exam_request':
            msg.value['examId'] == 'exr_id';
            msg.value['pat_cpf'] == 'exr_pat_cpf';
            msg.value['phyCpf'] == 'exr_phy_cpf';
            msg.value['hspSeq'] == 'ext_hsp_seq';
            msg.value['supId'] == 'exr_sup_id';
            msg.value['dateRequest'] == 'exr_date_request';
            msg.value['dateForecast'] == 'exr_date_forecast_release';
            msg.value['dateDelivery'] == 'exr_date_delivery';
            msg.value['urgency'] == 'exr_urgency';
            msg.value['examResult'] == 'exr_result';

            connection.end();
            //console.log(message.value)
        break;

    }
   
    /*
       
    case 'screening':      

    message.value['Inseir algum nome '] == 'scr_id';
    message.value[' '] == 'scr_reddish_spots';
    message.value[' '] == 'scr_fever';
    message.value[' '] == 'scr_cough';
    message.value[' '] == 'scr_malaise';
    message.value[' '] == 'scr_conjunctivitis';
    message.value[' '] == 'scr_coryza';
    message.value[' '] == 'scr_loss_of_appetite';
    message.value[' '] == 'scr_white_spots';
    message.value[' '] == 'scr_diarrhea';
    message.value[' '] == 'scr_convulsion';
    message.value[' '] == 'scr_ear_infection';
    message.value[' '] == 'scr_percentage';
    message.value[' '] == 'scr_date';
    message.value[' '] == 'pat_cpf';
    
    connection.end();
    break;
===========


    case 'medicalprocedure':

    message.value[' '] == 'mcp_procCode';
    message.value[' '] == 'mcp_name';

    connection.end();
    break;
===========

    case 'consultation_diagnosis':

    message.value[' '] == 'dig_cns_protocol';
    message.value[' '] == 'dig_code_cid';
    connection.end();
    break;
==========

    case 'speciality':

    message.value[' '] == 'spc_id';
    message.value[' '] == 'spc_desc'; 
    connection.end();
    break;
===========

    case 'consultationprocedure':

    message.value[' '] == 'cp_mcp_procCode';
    message.value[' '] == 'cp_cns_protocol';
    connection.end();
    break;
==========   

    case 'medicalconsultation':

    message.value[' '] == 'cns_protocol';
    message.value[' '] == 'cns_date';
    message.value[' '] == 'cns_comments';
    message.value[' '] == 'cns_createdAt';
    message.value[' '] == 'cns_updatedAt';
    message.value[' '] == 'cns_pat_cpf';
    message.value[' '] == 'cns_phy_cpf';
    connection.end();
    break;
=========

    case 'medicine':

    message.value[' '] == 'med_id';
    message.value[' '] == 'med_active_principle';
    message.value[' '] == 'med_code_ggrem';
    message.value[' '] == 'med_register';
    message.value[' '] == 'med_ean1';
    message.value[' '] == 'med_ean2';
    message.value[' '] == 'med_ean3';
    message.value[' '] == 'med_product_description';
    message.value[' '] == 'med_presentation';
    message.value[' '] == 'med_hospital_restrictions';
    message.value[' '] == 'med_cap';
    message.value[' '] == 'med_confaz87';
    message.value[' '] == 'med_marketing_year';
    message.value[' '] == 'med_sup_id';
    message.value[' '] == 'med_thc_id';
    message.value[' '] == 'med_pdt_id'; 
    message.value[' '] == 'med_stp_id';
    connection.end();
    break;

    default:
        console.log('Nenhuma tabela foi selecionada');
        break;






    message.value['type'] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';
    message.value[' '] == '';



































    */


});