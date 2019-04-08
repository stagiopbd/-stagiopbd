# 4_Fornecedores


## Setting up the docker environment
### Development environment
There is a **start_dev.sh** 
```shellscript
# Running at 'ipbl2019' folder
cd 4_Fornecedor
./start_dev.sh
```

After working with the containers, you can bring them down using the following command:
```shellscript
# shutdown containers and exclude mounted volumes
docker-compose down -v
```


## Consuming the APIs
### Using Postman

#### Importing the requests collection
In order to have access to all the requests already defined to consume our API, you need to import the file with all the requests:

    1. Open Postman and click on the "Import" button, at the upper left side
    2. Select the file called "ipbl.postman_collection.json", that is on the root of the project

After that, you can proceed to the next section.

#### Setting up the environment
In order to use the postman requests collection, you need to setup some
variables. This is done using the request called **Setup Variables**, located
in the root collection, but before that you'll need to create and select an
environment:

    1. Create an environment
        - There is a button in the upper-right corner, with a cog icon, called "Manage environments"
        - Click on it and then click on the "Add" button, which will be highlighted
        - Define a name to the environment (IPBL for example) and then click "Add"
        - Close the remaining popup
        - Select the new created environment, in the dropdown next to the cog icon
    2. Open the "Setup Variables" request and click send
    3. An error may be seen, but that's is ok since the endpoint defined doesn't really matter
    4. Click in the eye icon next to the environment dropdown to see the variables created
