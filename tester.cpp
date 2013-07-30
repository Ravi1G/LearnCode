using namespace std;
int test(int input, int des_output)
{
    FindSquare *obj = new FindSquare();
    clock_t start = clock();
    int ans = obj->square(input);
    clock_t end = clock();
    FILE *temp = fopen ("temp.txt","a");
    //fprintf(temp,"da%d\n",ans);
    delete obj;
    FILE *f = fopen("user_output.txt","a");
    fprintf(f,"Input: %d\n",input);
    fprintf(f,"User Output: %d\n",ans);
    fprintf(f,"Desired Output: %d\n",des_output);
    fprintf(f,"Time: %lf\n",(double)(end - start)/CLOCKS_PER_SEC);
    fprintf(f,"status:");
    if(ans == des_output)
    {
        fprintf(f," 1\n");
    }
    else
    {
        fprintf(f," 0\n");
    }
    fclose(f);
    
}

int main()
{
    FILE *f = fopen("user_output.txt","w");
    FILE *output_file = fopen("output.txt","r");
    FILE *temp = fopen ("temp.txt","w");
    //fprintf(temp,"dads");
    /*while(!feof(output_file))
    {
        char e[21];
        fscanf(output_file,"%s\n",e);
        fprintf(temp,"%s\n",e);
    }*/
    
    //fprintf(f,"dads");
    
    //fclose(f);
    for(int i = 1;i<6 ;i++)
    {
        //char expected[1000];
        char e[21];
        int t = 0;
        fgets(e,1000,output_file);
        fprintf(temp,"%s %d\n",e, strlen(e));
        for(int i =0;i<strlen(e)-1;i++)
        {
            t = t*10 + (e[i] - '0');
        }
        //fprintf(output_file,"fsdf");
        test(i,t);
    }
    fclose(temp);
    fclose(output_file);
    
    return 0;
}
