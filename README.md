# Magelearn_CustomerCreateCommand
Magento 2 Module which creates customer via command line interface with supplied parameters.

# Configurations

     * magelearn:customer:create
     *   [-f|--customer-firstname CUSTOMER-FIRSTNAME]
     *   [-l|--customer-lastname CUSTOMER-LASTNAME]
     *   [-e|--customer-email CUSTOMER-EMAIL]
     *   [-p|--customer-password CUSTOMER-PASSWORD]
     *   [-w|--website WEBSITE]
     *   [-s|--send-email [SEND-EMAIL]]
     *   [-ns|--newsletter-subscribe [NEWSLETTER-SUBSCRIBE]]
     *
## php bin/magento magelearn:customer:create -f "Vijay" -l "Rami" -e "vijay.rami@gmail.com" -p "test123" -w 1
## php bin/magento magelearn:customer:create -f "Vijay" -l "Rami" -e "vijay.rami@gmail.com" -p "test123" -w 1 -s 1 --newsletter-subscribe 1
