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
    
    NSInteger success = 0;
    @try {
        
        if([[self.usernameTextField text] isEqualToString:@""] || [[self.passwordTextField text] isEqualToString:@""] )
        {
            [self alertStatus:@"Please enter both username and password." :@"Empty Fields" :0];
        }
        
        else
        {
            
            NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"http://upresent.org/api/index.php/verify/%@/%@",[self.usernameTextField text],[self.passwordTextField text]]];
            
            NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
            [request setURL:url];
            [request setHTTPMethod:@"GET"];
            [request setValue:@"application/json" forHTTPHeaderField:@"Accept"];
            
            //[NSURLRequest setAllowsAnyHTTPSCertificate:YES forHost:[url host]];
            
            NSError *error = [[NSError alloc] init];
            NSHTTPURLResponse *response = nil;
            NSData *urlData=[NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
            
            NSLog(@"Response code: %ld", (long)[response statusCode]);
            
            if ([response statusCode] >= 200 && [response statusCode] < 300)
            {
                NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
                NSLog(@"Response ==> %@", responseData);
                
                NSError *error = nil;
                NSDictionary *jsonData = [NSJSONSerialization
                                          JSONObjectWithData:urlData
                                          options:NSJSONReadingMutableContainers
                                          error:&error];
                
                success = [jsonData[@"registered"] integerValue];
                NSLog(@"Success: %ld",(long)success);
                
                if(success == 1)
                {
                    NSLog(@"Login SUCCESS");
                } else if (success == 0)
                {
                    [self alertStatus:@"The username/password combination you entered is not valid. Please try again." :@"Incorrect Credentials" :0];
                    NSLog(@"Incorrect Credentials");
                } else {
                    [self alertStatus:@"Please try again." :@"Log In Failed" :0];
                }
                
            } else {
                //if (error) NSLog(@"Error: %@", error);
                [self alertStatus:@"Connection Failed" :@"Sign in Failed" :0];
            }
        }
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Sign in Failed." :@"Error" :0];
    }
    if (success) {
        [self performSegueWithIdentifier:@"login_success" sender:self];
    }

}

- (void) alertStatus:(NSString *)msg :(NSString *)title :(int) tag
{
    UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:title
                                                        message:msg
                                                       delegate:self
                                              cancelButtonTitle:@"Ok"
                                              otherButtonTitles:nil, nil];
    alertView.tag = tag;
    [alertView show];
}

- (BOOL) textFieldShouldReturn:(UITextField *)textField
{
    [textField resignFirstResponder];
    return YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)backgroundTap:(id)sender {
    [self.view endEditing:YES];
}
@end
