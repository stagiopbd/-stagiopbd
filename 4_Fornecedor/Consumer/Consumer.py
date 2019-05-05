# pip3 install kafka-python
# pip3 install mysql-connector-python

from kafka import KafkaConsumer
import mysql.connector
import json
import re

# Confirmar se a base existe e se os dados de acesso estão corretos
cnx = mysql.connector.connect(user='root', password='stagiopbdmysql**', host='localhost', database='stagiopbd_dev2')

# Se cadastra no tópico "det-fornecedor" do servidor Kafka apontado em bootstrap_servers.
# Demais parâmetros garantem que quando executar novamente irá ler somente mensagens recentes.
consumer = KafkaConsumer('det-fornecedor', bootstrap_servers=['localhost:9092'],
                         auto_offset_reset='earliest', enable_auto_commit=True,
                         auto_commit_interval_ms=1000, group_id='fornecedor',
                         value_deserializer=lambda m: json.loads(m.decode('utf-8')))

# Conexão com o banco MySQL
cursor = cnx.cursor()

add_stripe = ("INSERT INTO stripe "
"(stp_id, stp_description) "
"VALUES (%(stp_id)s, %(stp_description)s) "
"ON DUPLICATE KEY UPDATE stp_id = %(stp_id)s")

add_medicine = ("INSERT INTO medicine "
"(med_id, med_active_principle, med_code_ggrem, med_register, med_ean1, med_ean2, med_ean3, med_product_description, med_presentation, med_hospital_restrictions, med_cap, med_confaz87, med_marketing_year, med_sup_id, med_thc_id, med_pdt_id, med_stp_id) "
"VALUES (%(med_id)s, %(med_active_principle)s, %(med_code_ggrem)s, %(med_register)s, %(med_ean1)s, %(med_ean2)s, %(med_ean3)s, %(med_product_description)s, %(med_presentation)s, %(med_hospital_restrictions)s, %(med_cap)s, %(med_confaz87)s, %(med_marketing_year)s, %(med_sup_id)s, %(med_thc_id)s, %(med_pdt_id)s, %(med_stp_id)s) "
"ON DUPLICATE KEY UPDATE med_id = %(med_id)s")

add_person = ("INSERT INTO person "
"(psn_id, psn_name, psn_cnpjcpf, psn_address, psn_number, psn_complement, psn_neighborhood, psn_city, psn_estate, psn_zipcode, psn_country, psn_phone_inter_code, psn_phone_area_code, psn_phone_number, psn_email) "
"VALUES (%(psn_id)s, %(psn_name)s, %(psn_cnpjcpf)s, %(psn_address)s, %(psn_number)s, %(psn_complement)s, %(psn_neighborhood)s, %(psn_city)s, %(psn_estate)s, %(psn_zipcode)s, %(psn_country)s, %(psn_phone_inter_code)s, %(psn_phone_area_code)s, %(psn_phone_number)s, %(psn_email)s) "
"ON DUPLICATE KEY UPDATE psn_id = %(psn_id)s")

add_product_type = ("INSERT INTO product_type "
"(pdt_id, pdt_description) "
"VALUES (%(pdt_id)s, %(pdt_description)s) "
"ON DUPLICATE KEY UPDATE pdt_id = %(pdt_id)s")

add_supplier = ("INSERT INTO supplier "
"(sup_id, sup_fantasy_name, sup_open_date, sup_spt_id, sup_created_at, sup_updated_at, sup_deleted_at, sup_psn_id) "
"VALUES (%(sup_id)s, %(sup_fantasy_name)s, %(sup_open_date)s, %(sup_spt_id)s, %(sup_created_at)s, %(sup_updated_at)s, %(sup_deleted_at)s, %(sup_psn_id)s) "
"ON DUPLICATE KEY UPDATE sup_id = %(sup_id)s")

add_supplier_type = ("INSERT INTO supplier_type "
"(spt_id, spt_name, spt_created_at, spt_updated_at) "
"VALUES (%(spt_id)s, %(spt_name)s, %(spt_created_at)s, %(spt_updated_at)s) "
"ON DUPLICATE KEY UPDATE spt_id = %(spt_id)s")

add_therapeutic_class = ("INSERT INTO therapeutic_class "
"(thc_id, thc_descripition, thc_code) "
"VALUES (%(thc_id)s, %(thc_descripition)s, %(thc_code)s) "
"ON DUPLICATE KEY UPDATE thc_id = %(thc_id)s")

for msg in consumer:
    data = msg.value

    if data["type"] == "product_type":
        cursor.execute(add_product_type, data)
    elif data["type"] == "supplier_type":
        cursor.execute(add_supplier_type, data)
    elif data["type"] == "stripe":
        cursor.execute(add_stripe, data)
    elif data["type"] == "therapeutic_class":
        cursor.execute(add_therapeutic_class, data)
    elif data["type"] == "person":
        cursor.execute(add_person, data)
    elif data["type"] == "supplier":
       cursor.execute(add_supplier, data)
    elif data["type"] == "medicine":
        cursor.execute(add_medicine, data)

    cnx.commit()

cursor.close()
cnx.close()


