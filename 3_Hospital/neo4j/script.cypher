// Limpo o grafo
MATCH (n) DETACH DELETE n

// Carrego os dados via arquivos TSV
LOAD CSV WITH HEADERS FROM 'https://raw.githubusercontent.com/stagiopbd/ipbl2019/master/3_Hospital/neo4j/area.txt' AS line FIELDTERMINATOR '\u0009'
CREATE (:Area { name: line.area, city: line.city, state: line.state})

LOAD CSV WITH HEADERS FROM 'https://raw.githubusercontent.com/stagiopbd/ipbl2019/master/3_Hospital/neo4j/zipcode.txt' AS line FIELDTERMINATOR '\u0009'
CREATE (:Zipcode { code: line.zip_zipcode, street: line.zip_street, area: line.area, lat: line.Latitude, long: line.Longitude})

LOAD CSV WITH HEADERS FROM 'https://raw.githubusercontent.com/stagiopbd/ipbl2019/master/3_Hospital/neo4j/address.txt' AS line FIELDTERMINATOR '\u0009'
CREATE (:Address { id: line.adr_address, number: line.adr_number, zipcode: line.zip_zipcode})

LOAD CSV WITH HEADERS FROM 'https://raw.githubusercontent.com/stagiopbd/ipbl2019/master/3_Hospital/neo4j/patient.txt' AS line FIELDTERMINATOR '\u0009'
CREATE (:Patient { cpf: line.pat_cpf, name: line.pat_name, birthdate: line.pat_birthdate, gender: line.pat_gender, bloodtype: line.pat_bloodtype, email: line.pat_email, address: line.adr_address})

// Crio relacionamentos
MATCH (p:Patient), (a:Address) WHERE p.address = a.id CREATE (p)-[:HAS_ADDRESS]->(a)

MATCH (a:Address), (z:Zipcode) WHERE a.zipcode = z.code CREATE (a)-[:HAS_ZIPCODE]->(z)

MATCH (z:Zipcode), (a:Area) WHERE z.area = a.name CREATE (z)-[:HAS_AREA]->(a)

// Removo as propriedades que faziam o papel de chaves estrangeiras
MATCH (n:Patient) REMOVE n.address 

MATCH (n:Address) REMOVE n.zipcode, n.id 

MATCH (n:Zipcode) REMOVE n.area 