<?php
namespace Webit\Bundle\SmsApiBundle\Command;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;

use Symfony\Component\Console\Output\OutputInterface;

use Webit\Api\SmsCommon\Message\Sms;
use Webit\Api\SmsCommon\Message\Reciver;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class SendSmsCommand extends ContainerAwareCommand {
	protected function configure() {
		parent::configure();
		$this->setName('webit:smsapi:send_sms')
				->addArgument('message', InputArgument::REQUIRED)
				->addArgument('recivers', InputArgument::REQUIRED)
				->setDescription(
						'Send SMS');
	}

	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::initialize()
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) {

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$sms = new Sms();
		$sms->setContent($input->getArgument('message'));
		$arRecivers = explode(',',$input->getArgument('recivers'));
		if(count($arRecivers) == 0) {
			$output->writeln('<error>You have to set at least one reciver</error>');
			return;
		}
		
		foreach($arRecivers as $strReciver) {
			$sms->addReciver(new Reciver($strReciver));
		}
		
		$sender = $this->getContainer()->get('webit_sms_api.sms_sender');
		$response = $sender->sendSms($sms);
		if($response->getSuccess() == true) {
			$output->writeln('<info>Message has been sent successfully.</info>');
			$output->writeln('<info>Message Id: </info>'.$response->getId());
			$output->writeln('<info>Points taken: </info>'.$response->getPoints());
		} else {
			$error = $response->getErrors();
			$error = count($error) > 0 ? array_shift($error) : false;  
			
			$output->writeln('<error>Message hasn\'t been sent because of error. ('.($error ? $error->getCode() : 'Unknown error').')</error>');
			$output->writeln('<error>Error code: </error>'.$response->getId());
		}
	}
}
?>
