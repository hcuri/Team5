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


@end

@implementation UPresentRemoteViewController

@synthesize myTitle;
@synthesize title;
@synthesize currentSlide;
@synthesize totalSlides;
@synthesize myId;
int max;

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
    self.title.text = myTitle;
    [self getTotalSlides];
    self.currentSlide.text = [NSString stringWithFormat:@"%d",[self getCurrentSlide]];
}

- (IBAction)previousSlide:(id)sender {
    
    int curr = [self getCurrentSlide];
    
    if (curr==1) {
        [self alertStatus:@"You are at the First Slide" :@"Can't Go Back" :0];
    } else
        --curr;
    
    //Call method to set current slide with curr
    [self setCurrSlide:curr];
    currentSlide.text = [NSString stringWithFormat:@"%d",curr];
    
}
- (IBAction)nextSlide:(id)sender {
    
    int curr = [self getCurrentSlide];
    
    if (curr == max) {
        [self alertStatus:@"You are at the Last Slide" :@"Can't Go Forward" :0];
    } else
        ++curr;
    
    //call method to set current slide with curr
    [self setCurrSlide:curr];
    currentSlide.text = [NSString stringWithFormat:@"%d",curr];

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
            NSDictionary *json = [NSJSONSerialization
                             JSONObjectWithData:urlData
                             options:NSJSONReadingMutableContainers
                             error:&error];
            
            totalSlides.text = json[@"numSlides"];
            total = json[@"numSlides"];
            max = [total intValue];
            
        } else {
            if (error) NSLog(@"Error: %@", error);
            [self alertStatus:@"Connection Failed" :@"Sign in Failed" :0];
        }
        
    }
    @catch (NSException * e) {
        NSLog(@"Exception: %@", e);
        [self alertStatus:@"Reading Presentations Failed." :@"Error" :0];
    }

    return total;
}

- (int) getCurrentSlide
{
    NSNumber *current = 0;
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
