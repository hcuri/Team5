//
//  UPresentViewController.m
//  UPresent
//
//  Created by Hector Curi on 4/11/14.
//  Copyright (c) 2014 Team5. All rights reserved.
//

#import "UPresentViewController.h"

@interface UPresentViewController ()
@property (weak, nonatomic) IBOutlet UITextField *usernameTextField;
@property (weak, nonatomic) IBOutlet UITextField *passwordTextField;

@end

@implementation UPresentViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
}

- (IBAction)login:(id)sender {
    
    NSString *username = _usernameTextField.text;
    NSString *password = _passwordTextField.text;
    
    NSString *baseURL;
    baseURL = [NSString stringWithFormat:@"http://upresent.org/api/index.php/verify/%@/%@",username,password];
    
    NSMutableURLRequest *request =[NSMutableURLRequest requestWithURL:[NSURL URLWithString:baseURL]];
    [request setHTTPMethod:@"GET"];
    
    
    NSURLResponse *response;
    NSError *err;
    NSData *responseData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&err];
    
    
    NSString *responseStr = [NSString stringWithUTF8String:[responseData bytes]];
    NSLog(@"%@", responseStr);
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
