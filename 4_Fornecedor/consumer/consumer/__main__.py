from .consumers.medicines import Medicines
import pprint

med = Medicines()


rawmsg = '{"med_id":24416,"med_active_principle":"LUMACAFTOR;IVACAFTOR","med_code_ggrem":"575019010000101","med_register":"1382300010019","med_ean1":"7898962101025","med_ean2":"","med_ean3":"","med_product_description":"ORKAMBI","med_presentation":"125 MG\/DOSE + 200 MG\/DOSE COM REV CT BL AL PLAS TRANS X 112","med_hospital_restrictions":2,"med_cap":2,"med_confaz87":2,"med_marketing_year":0,"med_sup_id":110,"med_thc_id":450,"med_pdt_id":7,"med_stp_id":2,"type":"medicine"}'
msg = med.consumeAll([rawmsg])

print('result')
pprint.pprint(msg)