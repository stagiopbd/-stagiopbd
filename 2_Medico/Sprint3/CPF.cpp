#include<stdio.h>
#include<stdlib.h>
#include<string.h>
main()
{

   system("cls");
         int numero[9],soma1,soma2,i,erro,cpf,quant;
         int parte1,parte2,parte3,dig1;
         int parte5,parte6,parte7,dig2;
         printf("*==================================================================*\n");
         printf("|________________ GERADOR DE NUMEROS DE CPF V. 1.0 ________________|\n");
         printf("|                                                                  |\n");
         printf("*==================================================================*\n\n");
         printf("Deseja gerar quantos numeros de CPF: ");
         scanf("%d",&quant);
         printf("*==================================================================*\n");
         //*==========================================*
         //|        Geração dos numeros do CPF        |
         //*==========================================*
         for(cpf=1;cpf<=quant;cpf++)
         {
            for(i=1;i<= 9;i++)
            {
               erro=1;
               do
               {
                  if(erro>1)
                  {
                     printf("Numero invalido.\n");
                     erro=1;
                  }
                  numero[i]=rand()%9;
                  erro++;
               }while(numero[i]>9 || numero[i]<0);
            }
            //*==========================================*
            //|       Primeiro digito veridicador        |
            //*==========================================*
            soma1=((numero[1]*10)+
                  (numero[2]*9)+
                  (numero[3]*8)+
                  (numero[4]*7)+
                  (numero[5]*6)+
                  (numero[6]*5)+
                  (numero[7]*4)+
                  (numero[8]*3)+
                  (numero[9]*2));
            parte1=int(soma1 / 11);
            parte2=(parte1 * 11);
            parte3=(soma1 - parte2);
            dig1=(11 - parte3);
            if(dig1>9)dig1=0;
            //*==========================================*
            //|        Segundo digito veridicador        |
            //*==========================================*
            soma2=((numero[1]*11)+
                  (numero[2]*10)+
                  (numero[3]*9)+
                  (numero[4]*8)+
                  (numero[5]*7)+
                  (numero[6]*6)+
                  (numero[7]*5)+
                  (numero[8]*4)+
                  (numero[9]*3)+
                  (dig1*2));
            parte5=int(soma2 / 11);
            parte6=(parte5 * 11);
            parte7=(soma2 - parte6);
            dig2=(11 - parte7);
            if(dig2>9)dig2=0;
            //*==========================================*
            //|       Impressao do numero completo       |
            //*==========================================*
            for(i=1;i<=9;i++)
            {
               printf("%d",numero[i]);
               if(i-1==2) printf(".");
               if(i-1==5) printf(".");
            }
            printf("-%d%d\n",dig1,dig2); //dois últimos digitos
        }
         printf("Pressione \"enter\" para continuar...");
         getchar();
         getchar();
}
