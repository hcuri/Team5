//
//  UPresentRemoteViewController.m
//  UPresent
//
//  Created by Hector Curi on 4/21/14.
//  Copyright (c) 2014 Team5. All rights reserved.
//

#import "UPresentRemoteViewController.h"

@interface UPresentRemoteViewController ()
@property (strong, nonatomic) IBOutlet UILabel *title;
@property (strong, nonatomic) IBOutlet UILabel *currentSlide;
@property (weak, nonatomic) IBOutlet UILabel *totalSlides;
@property (weak, nonatomic) IBOutlet UIImageView *slideImage;


@end

@implementation UPresentRemoteViewController

@synthesize myTitle;
@synthesize title;
@synthesize currentSlide;
@synthesize totalSlides;
@synthesize myId;
@synthesize username;


int max;
NSNumber *current = 0;
NSDictionary *slides;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    UIImage *backgroundImage = [UIImage imageNamed:@"background"];
    UIImageView *backgroundImageView=[[UIImageView alloc]initWithFrame:self.view.frame];
    backgroundImageView.image=backgroundImage;
    [self.view insertSubview:backgroundImageView atIndex:0];
    self.title.text = myTitle;
    [self getTotalSlides];
    self.currentSlide.text = [NSString stringWithFormat:@"%d",[self getCurrentSlide]];
    
    
//    NSLog(@"%@",slides[@"slides"][@"1"]);
    
    NSString *fileURI = [slides[@"slides"][self.currentSlide.text] stringByReplacingOccurrencesOfString:@" "
                                                                                                withString:@"%20"];
    NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/%@",RootURL,fileURI]];
    self.slideImage.image = [UIImage imageWithData:[NSData dataWithContentsOfURL:url]];
    
    [self.slideImage.layer setBorderColor: [[UIColor blackColor] CGColor]];
    [self.slideImage.layer setBorderWidth: 1.0];
    
    
}

- (IBAction)previousSlide:(id)sender {
    
    int curr = [self getCurrentSlide];
    
    if (curr==1) {
        [self alertStatus:@"You are currently at the first slide." :@"Can't Go Back" :0];
    } else
        --curr;
    
    //Call method to set current slide with curr
    [self setCurrSlide:curr];
    currentSlide.text = [NSString stringWithFormat:@"%d",curr];
    
    NSString *fileURI = [slides[@"slides"][self.currentSlide.text] stringByReplacingOccurrencesOfString:@" "
                                                                                             withString:@"%20"];
    NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/%@",RootURL,fileURI]];
    self.slideImage.image = [UIImage imageWithData:[NSData dataWithContentsOfURL:url]];
    
}
- (IBAction)nextSlide:(id)sender {
    
    int curr = [self getCurrentSlide];
    
    if (curr == max) {
        [self alertStatus:@"You are currently at the last slide." :@"Can't Go Forward" :0];
    } else
        ++curr;
    
    //call method to set current slide with curr
    [self setCurrSlide:curr];
    currentSlide.text = [NSString stringWithFormat:@"%d",curr];
    
    
    NSString *fileURI = [slides[@"slides"][self.currentSlide.text] stringByReplacingOccurrencesOfString:@" "
                                                                                             withString:@"%20"];
    NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/%@",RootURL,fileURI]];
    self.slideImage.image = [UIImage imageWithData:[NSData dataWithContentsOfURL:url]];

}

- (IBAction)resetPoll:(id)sender {
    @try {
        
        NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/api/index.php/resetPoll",RootURL]];
        
        NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
        [request setURL:url];
        [request setHTTPMethod:@"POST"];
        
        NSString*post =[NSString stringWithFormat:@"{\"presId\":%@,\"slide\":%@}",myId,currentSlide.text];
        NSLog(@"%@",post);
        NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
        NSString *postLength = [NSString stringWithFormat:@"%lu",(unsigned long)[postData length]];
        
        [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
        [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
        [request setHTTPBody:postData];
        
        
        
        //[NSURLRequest setAllowsAnyHTTPSCertificate:YES forHost:[url host]];
        
        NSError *error = [[NSError alloc] init];
        NSHTTPURLResponse *response = nil;
        NSData *urlData=[NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
        
        NSLog(@"Response code: %ld", (long)[response statusCode]);
        
        if ([response statusCode] >= 200 && [response statusCode] < 300)
        {
            NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
            NSLog(@"Response ==> %@", responseData);
            
        } else {
            if (error) NSLog(@"Error: %@", error);
            [self alertStatus:@"Connection Failed" :@"Please Try Again" :0];
        }
        
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Restting Poll Failed." :@"Error" :0];
    }

    
}

- (IBAction)endPresentation:(id)sender {
    
    UIAlertView* message = [[UIAlertView alloc]
                            initWithTitle: @"End Presentation?"
                            message: @"The afterview screen will be displayed to the viewers."
                            delegate: self
                            cancelButtonTitle: @"Cancel"
                            otherButtonTitles: @"End", nil];
    
    [message show];
    
}

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex {
    if (buttonIndex == alertView.cancelButtonIndex) {
        // Cancel was tapped
    } else if (buttonIndex == alertView.firstOtherButtonIndex) {
        // The other button was tapped
        @try {
            
            NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/api/index.php/finishPresentation",RootURL]];
            
            NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
            [request setURL:url];
            [request setHTTPMethod:@"POST"];
            
            NSString*post =[NSString stringWithFormat:@"{\"presId\":%@}",myId];
            NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
            NSString *postLength = [NSString stringWithFormat:@"%lu",(unsigned long)[postData length]];
            
            [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
            [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
            [request setHTTPBody:postData];
            
            
            
            //[NSURLRequest setAllowsAnyHTTPSCertificate:YES forHost:[url host]];
            
            NSError *error = [[NSError alloc] init];
            NSHTTPURLResponse *response = nil;
            NSData *urlData=[NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
            
            NSLog(@"Response code: %ld", (long)[response statusCode]);
            
            if ([response statusCode] >= 200 && [response statusCode] < 300)
            {
                NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
                NSLog(@"Response ==> %@", responseData);
                
                [self.navigationController popViewControllerAnimated:YES];
                
            } else {
                if (error) NSLog(@"Error: %@", error);
                [self alertStatus:@"Connection Failed" :@"Please Try Again" :0];
            }
            
        }
        @catch (NSException * e) {
            NSLog(@"Exception: %@", e);
            [self alertStatus:@"Ending Presentations Failed." :@"Error" :0];
        }
    }
}

- (void) setCurrSlide: (int) slideNumber
{
    @try {
        
        NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/api/index.php/setCurrentSlide",RootURL]];
        
        NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
        [request setURL:url];
        [request setHTTPMethod:@"POST"];
        
        NSString*post =[NSString stringWithFormat:@"{\"presId\":%@,\"currSlide\":%d}",myId,slideNumber];
        NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
        NSString *postLength = [NSString stringWithFormat:@"%lu",(unsigned long)[postData length]];
        
        [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
        [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
        [request setHTTPBody:postData];


        
        //[NSURLRequest setAllowsAnyHTTPSCertificate:YES forHost:[url host]];
        
        NSError *error = [[NSError alloc] init];
        NSHTTPURLResponse *response = nil;
        NSData *urlData=[NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
        
        NSLog(@"Response code: %ld", (long)[response statusCode]);
        
        if ([response statusCode] >= 200 && [response statusCode] < 300)
        {
            NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
            NSLog(@"Response ==> %@", responseData);
            
        } else {
            if (error) NSLog(@"Error: %@", error);
            [self alertStatus:@"Connection Failed" :@"Sign in Failed" :0];
        }
        
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Reading Presentations Failed." :@"Error" :0];
    }

}

- (NSNumber*)getTotalSlides
{
    NSNumber *total = 0;
    @try {
        
        NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/api/index.php/getSlides/%@",RootURL,myId]];
        
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
            slides = [NSJSONSerialization
                             JSONObjectWithData:urlData
                             options:NSJSONReadingMutableContainers
                             error:&error];
            
            totalSlides.text = slides[@"numSlides"];
            
            total = slides[@"numSlides"];
            max = [total intValue];
            
        } else {
            if (error) NSLog(@"Error: %@", error);
            [self alertStatus:@"Connection Failed" :@"Try Again" :0];
        }
        
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Loading Presentation Failed." :@"Error" :0];
    }

    return total;
}

- (int) getCurrentSlide
{
    @try {
        
        NSURL *url=[NSURL URLWithString:[NSString stringWithFormat:@"%@/api/index.php/getCurrentSlide/%@",RootURL,myId]];
        
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
            NSDictionary *json = [NSJSONSerialization
                                  JSONObjectWithData:urlData
                                  options:NSJSONReadingMutableContainers
                                  error:&error];
            
            current = json[@"currSlide"];
            
        } else {
            if (error) NSLog(@"Error: %@", error);
            [self alertStatus:@"Connection Failed" :@"Sign in Failed" :0];
        }
        
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Reading Presentations Failed." :@"Error" :0];
    }
    
    return [current intValue];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

- (void) alertStatus:(NSString *)msg :(NSString *)titly :(int) tag
{
    UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:titly
                                                        message:msg
                                                       delegate:self
                                              cancelButtonTitle:@"Ok"
                                              otherButtonTitles:nil, nil];
    alertView.tag = tag;
    [alertView show];
}


@end
