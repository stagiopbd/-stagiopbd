

def formatar_vacina(item, setDesc=True, setCpf=True):
    result = {
        "vac_idvaccine": item.vac_idvaccine,
        "vac_date": item.vac_date,
        "vac_next": item.vac_next,
        "vac_batch": item.vac_batch,
        "vac_dose": item.vac_dose,
        "vac_responsible": item.vac_responsible,
        "vac_medicine": item.vac_medicine_id
    }

    if setDesc:
        result["med_product_description"] = item.vac_medicine.med_product_description

    if setCpf:
        result["vac_cpfpatient"] = item.vac_cpfpatient_id

    return result


def formatar_vacina_dict(item, setDesc=True, setCpf=True):
    result = {
        "vac_idvaccine": item['vac_idvaccine'],
        "vac_date": item['vac_date'],
        "vac_next": item['vac_next'],
        "vac_batch": item['vac_batch'],
        "vac_dose": item['vac_dose'],
        "vac_responsible": item['vac_responsible'],
        "vac_medicine": item['vac_medicine']
    }

    if setDesc:
        result["med_product_description"] = item.vac_medicine.med_product_description

    if setCpf:
        result["vac_cpfpatient"] = item.vac_cpfpatient_id

    return result
