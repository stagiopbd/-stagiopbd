var dbConnection = require('./connectionDB');

var connection = dbConnection();

var msg = {'type': 'exam_request',examId: 218, pat_cpf: '68871246373', phyCpf: '22214413707', hspSeq: 2121,
supId: 1, dateRequest: '2019-06-06', dateForecast: '2019-06-06', dateDelivery: '2019-06-06', urgency:'3' }

text = JSON.stringify(msg)

var kafka = require('kafka-node'),
    Producer = kafka.Producer,
    KeyedMessage = kafka.KeyedMessage,
    client = new kafka.KafkaClient(),
    producer = new Producer(client),
   // km = new KeyedMessage('key', 'message'),
    payloads = [
        { topic: 'det_medico', messages: text , partition: 0 }
        //,{ topic: 'topic2', messages: ['hello', 'world', km] }
    ];
producer.on('ready', function () {
    producer.send(payloads, function (err, data) {
        console.log(data);

        connection.connect();
        
        connection.query('INSERT INTO exam_request( exr_id, exr_pat_cpf, exr_phy_cpf, exr_hsp_seq, exr_sup_id, exr_date_request, exr_date_forecast_release, exr_date_delivery, exr_urgency) VALUES(?,?,?,?,?,?,?,?,?)', 
        [msg.examId, msg.pat_cpf, msg.phyCpf, msg.hspSeq, msg.supId, msg.dateRequest, msg.dateForecast, msg.dateDelivery, msg.urgency],
        function (error, results) {
          
          if (error) throw error;
        });
        
      
        connection.end();
    });
});
 
producer.on('error', function (err) {})

/*
{'type': 'exam_request', 'exr_id': '1000', 'exr_pat_cpf': 'None', 'exr_phy_cpf': 'None',
'ext_hsp_seq': 'None', 'exr_sup_id': 'None', 'exr_date_request': 'None', 
'exr_date_forecast_release': 'None', 'exr_date_delivery': 'None', 'exr_urgency': 'None', 'exr_result': 'None'}


{'type': 'screening', 'scr_id': '', 'scr_reddish_spots': '', 'scr_fever': '',
'scr_cough': '', 'scr_malaise': '', 'scr_conjunctivitis': '', 
'scr_coryza': '', 'scr_loss_of_appetite': '', 'scr_white_spots': '',
'scr_diarrhea': '', 'scr_convulsion': '', 'scr_ear_infection': '', 
'scr_percentage': '', 'scr_date': '', 'pat_cpf': ''} 


{'type': 'medicalprocedure', 'mcp_procCode': '', 'mcp_name': '' }

{'type': 'consultation_diagnosis', 'dig_cns_protocol': '', 'dig_code_cid': ''}

{'type': 'speciality', 'spc_id': '', 'spc_desc': ''}

{'type': 'consultationprocedure', 'cp_mcp_procCode': '', ''cp_cns_protocol: ''}


{'type': 'medicalconsultation', 'cns_protocol': '', 'cns_date': '', 
'cns_comments': '', 'cns_createdAt': '', 'cns_updatedAt': '',
'cns_pat_cpf': '', 'cns_phy_cpf': ''}

{'type': 'medicine', 'med_id': '', 'med_active_principle': '',
'med_code_ggrem': '', 'med_register': '', 
'med_ean1': '', 'med_ean2': '', 'med_ean3': '',
'med_product_description': '', 'med_presentation': '',
'med_hospital_restrictions': '', 'med_cap': '', 'med_confaz87': '',
'med_marketing_year': '', 'med_sup_id': '',
'med_thc_id': '', 'med_pdt_id': '', 'med_stp_id': ''}


*/