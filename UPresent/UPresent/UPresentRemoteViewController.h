//
//  UPresentRemoteViewController.h
//  UPresent
//
//  Created by Hector Curi on 4/21/14.
//  Copyright (c) 2014 Team5. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <QuartzCore/QuartzCore.h>
#import "String.h"

@interface UPresentRemoteViewController : UIViewController <UIAlertViewDelegate>

@property(nonatomic) NSString *myTitle;
@property(nonatomic) NSString *myId;
@property(nonatomic) NSString *username;


@end
