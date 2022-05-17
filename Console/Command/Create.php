<?php

namespace Magelearn\CustomerCreateCommand\Console\Command;

use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magelearn\CustomerCreateCommand\Helper\Customer;

/**
 * Create Command class
 */
class Create extends Command
{
    /**
     * @var Customer
     */
    private $customerHelper;

    /**
     * @var State
     */
    private $state;

    /**
     * Create constructor.
     * @param Customer $customerHelper
     * @param State $state
     */
    public function __construct(
        Customer $customerHelper,
        State $state
    ) {
        $this->customerHelper = $customerHelper;
        $this->state = $state;
        parent::__construct();
    }

    /**
     * magelearn:customer:create
     *   [-f|--customer-firstname CUSTOMER-FIRSTNAME][REQUIRED]
     *   [-l|--customer-lastname CUSTOMER-LASTNAME][REQUIRED]
     *   [-e|--customer-email CUSTOMER-EMAIL][REQUIRED]
     *   [-p|--customer-password CUSTOMER-PASSWORD][REQUIRED]
     *   [-w|--website WEBSITE][REQUIRED]
     *   [-s|--send-email [SEND-EMAIL]][OPTIONAL]
     *   [-ns|--newsletter-subscribe [NEWSLETTER-SUBSCRIBE]][OPTIONAL]
     *
     * php bin/magento magelearn:customer:create -f "Vijay" -l "Rami" -e "vijay.rami@gmail.com" -p "test123" -w 1
     * php bin/magento magelearn:customer:create -f "Vijay" -l "Rami" -e "vijay.rami@gmail.com" -p "test123" -w 1 -s 1 --newsletter-subscribe 1
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return int|void|null
     * 
     * Style the output text by using <error>, <info>, or <comment>
     * For More Info check at https://symfony.com/doc/current/console/coloring.html
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $output->writeln('<info>Creating new user</info>');
        $this->customerHelper->setData($input);

        $customer = $this->customerHelper->createCustomer();
        
        if ($customer && $customer->getId()) {
            $output->writeln("<info>Created new user</info>");
            $output->writeln((string) __("<comment>User ID: %1</comment>", $customer->getId()));
            $output->writeln((string) __("<comment>First name: %1</comment>", $customer->getFirstname()));
            $output->writeln((string) __("<comment>Last name: %1</comment>", $customer->getLastname()));
            $output->writeln((string) __("<comment>Email: %1</comment>", $customer->getEmail()));
            $output->writeln((string) __("<comment>Website Id: %1</comment>", $customer->getWebsiteId()));
            if ($input->getOption(Customer::KEY_NEWSLETTER_SUBSCRIBE)) {
                $output->writeln("<comment>Subscribed to Newsletter</comment>");
            }
            if ($input->getOption(Customer::KEY_SENDEMAIL)) {
                $output->writeln("<comment>Sending Email</comment>");
            }
        } else {
            $output->writeln("<error>Problem creating new user</error>");
            if ($e = $this->customerHelper->getException()) {
                $output->writeln((string) __("<error>%1</error>", $e->getMessage()));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("magelearn:customer:create");
        $this->setDescription("Create new customer with supplied arguments");
        $this->setDefinition([
            new InputOption(Customer::KEY_FIRSTNAME, '-f', InputOption::VALUE_REQUIRED, '(Required) First name'),
            new InputOption(Customer::KEY_LASTNAME, '-l', InputOption::VALUE_REQUIRED, '(Required) Last name'),
            new InputOption(Customer::KEY_EMAIL, '-e', InputOption::VALUE_REQUIRED, '(Required) Email'),
            new InputOption(Customer::KEY_PASSWORD, '-p', InputOption::VALUE_REQUIRED, '(Required) Password'),
            new InputOption(Customer::KEY_WEBSITE, '-w', InputOption::VALUE_REQUIRED, '(Required) Website ID'),
            new InputOption(Customer::KEY_SENDEMAIL, '-s', InputOption::VALUE_OPTIONAL, '(Optional)(1/0) Send email (default 0)'),
            new InputOption(Customer::KEY_NEWSLETTER_SUBSCRIBE, '-ns', InputOption::VALUE_OPTIONAL, '(Optional)(1/0) Subscribe to Newsletter (default 0)')
        ]);
        parent::configure();
    }
}
