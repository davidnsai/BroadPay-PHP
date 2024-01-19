# Broadpay PHP Package

This is a PHP package for the Broadpay Zambia Fintech API. The API allows merchants to add online payment functionalities to their websites and apps. The API allows merchants to collect payments via Mobile Money and Debit/Credit Card. This package simplifies the integration process with PHP web apps for newbie developers.


## Installation

This package can be installed to your project using the following composer command:

    composer require davidnsai/davidnsai-broadpay-php
In case you can any errors during the installations, please run the following commands:

    composer config minimum-stability dev
    composer config prefer-stable true
The above commands change the minimum stability in your project's `composer.json`

## Usage

At present, the package supports collection and sending of money to and from mobile wallets using the REST API. It also supports creation of Hosted checkout links.

### Hosted Payments

Hosted checkout links can be created using the sample code below:
The code below assumes you are using a framework which has autoload functionality like CodeIgniter or Laravel.

    <?php
        namespace YourNamespace;
	    use Broadpay\HostedPayments\Checkout;
	    
        class YourClassNameHere 
        {    	    
    	    public function paymentMethod()
    	    {
	    	    $checkout = new Checkout(
		    	    $public_key, //string
		    	    $transction_name, //string
		    	    $amount, //float
		    	    $currency, //string
		    	    $unique_merchant_reference, //string
		    	    $customer_email, //string
				      $customer_firstname, //string
				      $customer_lastname, //string
				      $customer_phone, //string
				      $customer_address, //string
				      $customer_city, //string
				      $customer_state, //string
				      $customer_country_code, //string
				      $customer_postal_address, //string
				      $webhook_url, //string, optional
				      $redirect_url, //string, optional
				      $auto_redirect, //bool, optional
				);
				$checkout_details  =  $checkout->createCheckoutLink();
    	    }   		
        }

The following if the expected structure of data to be assigned to `$checkout_details` upon making a successful call to the server:

        //json
        {
		     "isError": false,
		      "message": "",
		      "paymentUrl":"https://checkout.sparco.io/eyJpZCI6IDEsICJtZXJjaGFudFB1YmxpY0tleSI6ICIyZmJmMTgyYzZmYzE0NTAwYjI4ZmRjOGM4M2VhYjczNCJ9",
		      "reference": "7b226964223a20312c20226d6964223a20317d"
		}

### REST API
The API also allows the collection for funds a REST API call. The following sample code shows how this can be done:

    <?php
    namespace  YourNamespace;        
    use Broadpay\MobileMoney\Debit;
    class  YourClassName
    {
	    public  function  index()
	    {
    
		    $payment = new Debit(
			    privateKey: 'YourPrivateKey',
			    publicKey: 'YourPublicKey',
			    amount: 100,
			    currency: 'ZMW',
			    customerEmail: 'david@davidnsai.com',
			    customerFirstName: 'david',
			    customerLastName: 'nsai',
			    customerPhone: ''+260977123456,
			    transactionName: 'Transaction name here',
			    transactionReference: 'Unique Transaction Reference',
			    wallet: '0977123456'
			   );
				
			$payment_result = $payment->initialiseCollection();
		 }
	}
	
	

The following if the expected structure of data to be assigned to `$checkout_details` upon making a successful call to the server:

    //json
    {
      "isError": false,
      "mesasge": "Wating for wallet holder to authorize debit transaction.",
      "message": "",
      "reference": "7b226964223a20332c20226d6964223a20317d",
      "status": "PENDING_AUTH"
    }

I hope you will find this package useful as you build your PHP apps with Broadpay. Happy coding!!




